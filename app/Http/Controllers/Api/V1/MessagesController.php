<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Http\Resources\MessageResource;

class MessagesController extends Controller
{
    /**
     * getLoadLatestMessages
     *
     *
     * @param Request $request
     */
    public function getLoadLatestMessages(Request $request)
    {
        $this->validateRequest('load');

        $messages = Message::where(function($query) use ($request) {
            $query->where('from_user', auth()->user()->id)->where('to_user', $request->user_id);
        })->orWhere(function ($query) use ($request) {
            $query->where('from_user', $request->user_id)->where('to_user', auth()->user()->id);
        })->orderBy('created_at', 'ASC')->limit(10)->get();


        return response()->json(['state' => true, 'data' => MessageResource::collection($messages)]);
    }

    /**
     * postSendMessage
     *
     * @param Request $request
     */
    public function store(Request $request)
    {

        $this->validateRequest();
 
        $message = new Message();
        $message->from_user = auth()->user()->id;
        $message->to_user = $request->to_user;
        $message->content = $request->message;
        $message->save();
  
        return response()->json(['state' => true, 'data' => new MessageResource($message) ]);
    }

    /**
     * getOldMessages
     *
     * we will fetch the old messages using the last sent id from the request
     * by querying the created at date
     *
     * @param Request $request
     */
    public function getOldMessages(Request $request)
    {
        $this->validateRequest('old');

 
        $message = Message::find($request->old_message_id);
 
        $lastMessages = Message::where(function($query) use ($request, $message) {
            $query->where('from_user', auth()->user()->id)
                ->where('to_user', $request->to_user)
                ->where('created_at', '<', $message->created_at);
            })->orWhere(function ($query) use ($request, $message) {
            $query->where('from_user', $request->to_user)
                ->where('to_user', auth()->user()->id)
                ->where('created_at', '<', $message->created_at);
            })->orderBy('created_at', 'ASC')->limit(10)->get();
 
 
        if($lastMessages->count() > 0) {
 
            return response()->json(['state' => true, 'data' => MessageResource::collection($lastMessages)]);

 
        }
 
        return response()->json(['state' => false, 'message' => 'Not have messages!!']);
    }

    private function validateRequest($type = "store")
    {
        if($type == "load"){
            return request()->validate([
                'user_id' => 'required',
            ]);
        }

        if($type == "old"){
            return request()->validate([
                'old_message_id' => 'required',
                'to_user' => 'required',

            ]);
        }

        return request()->validate([
            'to_user' => 'required',
            'message' => 'required',
        ]);

    }

    private function storeImage($message)
    {
        if (request()->has('image')) {
            $message->update([
                'content' => request()->image->store('uploads', 'public'),
            ]);

        }
    }
}
