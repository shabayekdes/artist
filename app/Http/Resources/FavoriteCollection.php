<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FavoriteCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function($item, $key){
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
                "category" => $item->category,
                "artist" => new UserResource($item->user)
            ];
        });
    }
}
