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
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => number_format($this->sell_price, 2),
            'color' => [
                'id' => $this->color->id,
                'name' => $this->color->name
            ],
            'size' => [
                'id' => $this->size->id,
                'name' => $this->size->name
            ],
            'condition' => [
                'id' => $this->condition->id,
                'name' => $this->condition->name
            ],
            'material' => [
                'id' => $this->material->id,
                'name' => $this->material->name
            ],
            'section' => [
                'id' => $this->section->id,
                'name' => $this->section->name
            ],
            'branch' => [
                'id' => $this->branch->id,
                'name' => $this->branch->name,
                'address' => $this->branch->address,
                'working_hours' => $this->branch->working_hours,
                'phone' => $this->branch->phone,
                'whatsapp' => $this->branch->whatsapp
            ],
            'location' => $this->location,
            'is_for_sale' => $this->is_for_sale,
            'user' => isset($this->user->email)? $this->user->email :null,
            // 'user' => $this->user->email ,
            'categories' => ['id' => $this->category->id, 'name' => $this->category->name],
            'images' => $this->images->map(function ($image) {
                return [
                    'is_default' => $image->is_default,
                    'path' => $image->path,
                ];
            }),
            'sku' => $this->sku
        ];
    }
}
