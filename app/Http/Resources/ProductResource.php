<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $thumbnailLink = $this->thumbnail ? asset('files/product/' . $this->thumbnail) : null;

        $images = $this->images ? json_decode($this->images, true) : [];
        $imagesLink = array_map(function ($image) {
            return asset('files/product/' . $image);
        }, $images);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'code' => $this->code,
            'unit' => $this->unit,
            'tags' => $this->tags,
            'color' => $this->color,
            'size' => $this->size,
            'video' => $this->video,
            'purchase_price' => $this->purchase_price,
            'selling_price' => $this->selling_price,
            'discount_price' => $this->discount_price,
            'stock_quantity' => $this->stock_quantity,
            'description' => $this->description,
            'thumbnail' => $this->thumbnail,
            'thumbnail_link' => $thumbnailLink,
            'images' => $this->images,
            'images_link' => $imagesLink,
            'featured' => $this->featured,
            'today_deal' => $this->today_deal,
            'product_slider' => $this->product_slider,
            'trendy' => $this->trendy,
            'status' => $this->status,
            // 'average_rating' =>  number_format($this->averageRating(), 2),
            'average_rating' =>  $this->averageRating(),
            'category' => new CategoryResource($this->whenLoaded('category')),

            'review' => ReviewResource::collection($this->whenLoaded('review')),
            'brand' =>  new BrandResource($this->whenLoaded('brand')),
            'warehouse' => $this->warehouse,
            'pickup_point' => $this->pickup_point,
            'user' => new UserResource($this->whenLoaded('user')),

            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}