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
            "price" => $this->price,
            "new" => $this->new,
            "featured" => $this->featured,
            "rating" => $this->rating,
            "thumbnail" => url("storage/" . $this->thumbnail),
            "description" => $this->description ?? "",
            "status" => $this->status,
            "category" => $this->category,
            "artist" => new UserResource($this->user),
            "size" => $this->attributes->where('type', 'size')->toArray(),
            "position" => $this->attributes->where('type', 'position')->toArray(),

        ];
    }
}
