<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $customer = Auth::guard('api')->user();
        // Get the current page from the request or default to 1
        $page = $request->input('page', 1);

        // Define a unique cache key for each page
        $cacheKey = "customer_orders_{$customer->id}_page_{$page}";
        $orders = Cache::remember($cacheKey, now()->addMinutes(1), function () use ($customer) {
            return $customer->orders()->with('customer')->paginate(2); // ,'orderItems', 'billingAddress'
        });
        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $orderData = $request->validate([

            // 'status' => [
            //     Rule::in([
            //         'initiated',
            //         'completed',
            //         'processing',
            //         'shipped',
            //         'delivered',
            //         'canceled',
            //         'refunded',
            //         'pending payment',
            //         'payment received',
            //         'out for delivery',
            //         'expired',
            //         'on-hold',
            //         'backordered',
            //         'returned',
            //         'partially shipped',
            //         'awaiting fulfillment',
            //         'fraud detected',
            //         'pending approval',
            //         'on backorder',
            //     ]),
            // ],
            'note' => 'nullable|string|between:10,500',
            // cart
            'order_items' => 'required|array|min:1',
            'order_items.*.id' => 'required|exists:products,id',
            'order_items.*.name' => 'required|between:5,500',
            'order_items.*.qty' => 'required|integer|min:1',
            'order_items.*.price' => 'required|numeric|min:0',
            // shipping adress
            'shipping_name' => 'required|string|between:5,500',
            'shipping_phone' => 'required|string|between:5,15',
            'shipping_address' => 'required|string|between:5,500',
            'shipping_postal_code' => 'required|string|max:20',
            // billing Address (conditionally required)
            'isBillingAddressSame' => 'required|boolean',
            'billing_name' => 'exclude_if:isBillingAddressSame,true|required|string|between:5,500',
            'billing_phone' => 'exclude_if:isBillingAddressSame,true|required|string|between:5,15',
            'billing_address' => 'exclude_if:isBillingAddressSame,true|required|string|between:5,500',
            'billing_postal_code' => 'exclude_if:isBillingAddressSame,true|required|string|max:20',
        ]);
        $customer = Auth::guard('api')->user();
        $orderData['customer_id'] = $customer->id;

        try {
            DB::beginTransaction();

            $orderData['total_price'] =  0;
            // Create the order in the database
            $order = Order::create($orderData);

            // Create order items
            foreach ($orderData['order_items'] as $item) {

                // Assuming you have a Product model
                $product = Product::find($item['id']);

                if ($product) {
                    // Create OrderItem and set the price based on the current value in the product table
                    $orderItem = new OrderItem([
                        'product_id' => $item['id'],
                        'quantity' => $item['qty'],
                        'price_at_order' => $product->selling_price,
                    ]);
                    // Calculate and accumulate the total price
                    $orderData['total_price'] += $orderItem->price_at_order;
                    // Save the OrderItem
                    $order->orderItems()->save($orderItem);
                }
            }
            // Save the calculated total price to the order
            $order->update(['total_price' => $orderData['total_price']]);

            // Create shipping address 
            $shippingAddress = new CustomerAddress([
                'name' => $orderData['shipping_name'],
                'phone' => $orderData['shipping_phone'],
                'address' => $orderData['shipping_address'],
                'postal_code' => $orderData['shipping_postal_code'],
            ]);

            // Save the shipping address through the relationship
            $customer->addresses()->save($shippingAddress);

            // Associate shipping address with the order
            $order->shippingAddress()->associate($shippingAddress);

            if (!$orderData['isBillingAddressSame']) {
                // Create billing address
                $billingAddress = new CustomerAddress([
                    'name' => $orderData['billing_name'],
                    'phone' => $orderData['billing_phone'],
                    'address' => $orderData['billing_address'],
                    'postal_code' => $orderData['billing_postal_code'],
                ]);

                // Save the billing address through the relationship
                $customer->addresses()->save($billingAddress);

                // Associate billing address with the order
                $order->billingAddress()->associate($billingAddress);
            } else {
                $order->billingAddress()->associate($shippingAddress);
            }
            // Save the order after associating addresses
            $order->save();
            DB::commit();

            return response()->json(['message' => 'Order created successfully', 'data' => $order], 200);
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            // Handle the exception as needed (log it, return an error response, etc.)
            return response()->json(['error' => 'Failed to create the order' . $e], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('shippingAddress',  'orderItems');
        return  new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order, Request $request)
    {
        $order->delete();
        return $this->index($request);
    }

    // public function deleteCache($customer =  Auth::guard('api')->user())
    // {
    //     // $customer = Auth::guard('api')->user();
    //     // Clear all pages' cache associated with the user
    //     Cache::forget("customer_orders_{$customer->id}_page_*");
    // }
}