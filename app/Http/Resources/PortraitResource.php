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
            "name" => $this->id,
            "sku" => $this->id,
            "slug" => $this->id,
            "quantity" => $this->id,
            "price" => $this->id,
            "featured" => $this->id,
            "new" => $this->id,
            "thumbnail" => $this->id,
            "description" => $this->id,
            "status" => $this->id,
            "category_id" => $this->id,
            "user_id" => $this->id
        ];
    }
}
