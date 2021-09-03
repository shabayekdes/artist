<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AlertResource;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $alerts = auth()->user()->alerts;

        return AlertResource::collection($alerts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Alert  $alert
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alert $alert)
    {

        $alert->update(['is_seen' => $request->get('is_seen')]);

        return response()->json(['status' => true, 'message' => 'Alert has updated'], 200);
    }
}
