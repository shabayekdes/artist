<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $portraits = $this->portraits != null ?$this->portraits->map(function($item, $key){
            return [
                "id" => $item->id,
                "name" => $item->name,
                "sku" => $item->sku,
                "slug" => $item->slug,
                "quantity" => $item->quantity,
                "price" => $item->price,
                "new" => $item->new,
                "featured" => $item->featured,
                "rating" => $item->rating,
                "thumbnail" => url($item->thumbnail),
                "description" => $item->description ?? "",
                "status" => $item->status,
                "artist" => new UserResource($item->user)
            ];
        }) : [];

        return [
            "id" => $this->id,
            "name"=> $this->name,
            "slug"=> $this->slug,
            "description"=> $this->description ?? "",  
            "image"=> url($this->image),
            "portraits" => $portraits
        ];
    }
}
