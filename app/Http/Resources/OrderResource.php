<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        static $slNo = 0;
        $slNo++;
        return [
            'id' => $this->id,
            'note' => $this->note,
            'status' => $this->status,
            'total_price' => $this->total_price,
            'SL_no' => $slNo,

            'items' => OrderItemsResource::collection($this->whenLoaded('orderItems')),
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'shipping_address' => new CustomerAddressResource($this->whenLoaded('shippingAddress')),
            'billing_address' => new CustomerAddressResource($this->whenLoaded('billingAddress')),
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            // Add other fields as needed
        ];
    }
}
