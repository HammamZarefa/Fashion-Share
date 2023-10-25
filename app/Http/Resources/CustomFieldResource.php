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

        if ($this->category_id)
            $data['category_id'] = $this->category_id;

         if ($this->section_id)
            $data['section_id'] = $this->section_id;
        
        if($this->Hexcolor)
            $data['Hexcolor'] = $this->Hexcolor;
        
        if($this->address)
            $data['address'] = $this->address;
        if($this->location)
            $data['location'] = $this->location;
        if($this->working_hours)
            $data['working_hours'] =$this->working_hours;
        if($this->phone)
            $data['phone'] =$this->phone;
        if($this->whatsapp)
            $data['whatsapp'] =$this->whatsapp;

        

        return $data;

    }
}
