<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $nestedParents = $this->allParentCategories()->map(function ($parentCategory) {
        //     return new CategoryResource($parentCategory);
        // });
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'slug' => $this->slug,
            'image' => $this->image,
            'icon' => $this->icon,
            'parent_id' => $this->parent_id,

            // 'parent_categories' => ProductResource::collection($this->whenLoaded('children')),
            // 'brands' => BrandResource::collection($this->whenLoaded('brands')), // Load and display brands.

            'products' => ProductResource::collection($this->whenLoaded('products')),
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}
