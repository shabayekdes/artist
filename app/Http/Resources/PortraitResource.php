<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CategoryResource;

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
            "new" => $this->new,
            "featured" => $this->featured,
            "rating" => $this->rating,
            "thumbnail" => url($this->thumbnail),
            "description" => $this->description ?? "",
            "status" => $this->status,
            "category" => new CategoryResource($this->category),
            "artist" => new UserResource($this->user)
        ];
    }
}
