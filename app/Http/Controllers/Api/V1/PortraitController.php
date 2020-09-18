<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Portrait;
use App\Http\Resources\PortraitResource;

class PortraitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  Portrait  $portrait
     * @return \Illuminate\Http\Response
     */
    public function show(Portrait $portrait)
    {
        $portrait->load('attributes');

        $attributes = $portrait->attributes->groupBy('type')->toArray();

        $data = [
            'portait' => new PortraitResource($portrait),
            'size' => isset($attributes['size']) ? $attributes['size'] : [],
            'type' => isset($attributes['type']) ? $attributes['type'] : []
        ];
        // dd($data);
        return response()->json(['status' => true, 'data' => $data ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
