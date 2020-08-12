<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PortraitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "sku" => $this->sku,
            "slug" => $this->slug,
            "quantity" => $this->quantity,
            "price" => $this->price,
            "featured" => $this->featured,
            "new" => $this->new,
            "thumbnail" => url( '/' . $this->thumbnail),
            "description" => $this->description,
            "status" => $this->status,
            "category_id" => $this->category,
            "user_id" => $this->user
        ];
    }
}
