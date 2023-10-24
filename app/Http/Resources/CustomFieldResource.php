<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomFieldResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
        ];

        if ($this->image)
            $data['image'] = $this->image;

        if ($this->description)
            $data['description'] = $this->description;
        return $data;

        if ($this->category_id)
            $data['category_id'] = $this->category_id;

         if ($this->section_id)
            $data['section_id'] = $this->section_id;
        return $data;

    }
}
