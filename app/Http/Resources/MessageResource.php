<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'id' => $this->id,
            'content' => $this->content,
            'dateTimeStr' => date("Y-m-dTH:i", strtotime($this->created_at->toDateTimeString())),
            'dateHumanReadable' => $this->created_at->diffForHumans(),
            'fromUserName' => new UserResource($this->fromUser),
            'toUserName' => new UserResource($this->toUser),
        ];
    }
}
