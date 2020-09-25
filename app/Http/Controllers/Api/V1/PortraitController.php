<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Portrait;
use App\Models\PortraitAttribute;
use App\Http\Resources\PortraitResource;
use Illuminate\Support\Str;

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

        $size = json_decode($request->get('size'), true);
        $position = json_decode($request->get('position'), true);

        $portrait = Portrait::create([
            'name' => $request->get('name'),
            'sku' => Str::random(40),
            'price' => $request->get('price'),
            'thumbnail' => $request->get('test'),
            'description' => $request->get('description'),
            'category_id' => $request->get('category_id'),
            'user_id' => auth()->user()->id,
        ]);


        foreach ($size as $key => $item) {
            PortraitAttribute::create([
                'portrait_id' => $portrait->id,
                'value' => $item,
                'type' => 'size'
            ]);
        }

        foreach ($position as $key => $item) {
            PortraitAttribute::create([
                'portrait_id' => $portrait->id,
                'value' => $item,
                'type' => 'postion'
            ]);
        }

        return response()->json(['status' => true, 'message' => 'Portrait was added successfully' ]);

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
