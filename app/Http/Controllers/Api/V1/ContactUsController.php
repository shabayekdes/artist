<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupportMessage;

class ContactUsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'message' => 'required',
        ]);

        SupportMessage::create([
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'message' => $request->get('message')
        ]);

        return response()->json(['status' => true, 'message' => 'message was added!!'], 201);


    }

}
