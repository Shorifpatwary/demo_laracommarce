<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'rating' => $this->rating,
            'approved' => $this->approved,
            'featured' => $this->featured,
            // Add other fields as needed
            'product' => new ProductResource($this->whenLoaded('product')),
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}
