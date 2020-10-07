<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            "item_count" => $this->item_count,
            "grand_total" => $this->grand_total,
            "user_id" => $this->user,
            "portraits" => $this->portraits->map(function($item, $key){
                return [
                    "id"=> $item->id,
                    "quantity"=> $item->quantity,
                    "total"=> $item->total,
                    "cart_id"=> $item->cart_id,
                    "portrait_id"=> $item->portrait_id,
                    "attributes" => $item->portraitAttributes
                ];
            }),

        ];
    }
}
