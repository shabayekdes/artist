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

        $search = request()->query('search');

        $portraits = Portrait::where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")->get();


        return response()->json(['status' => true, 'data' => PortraitResource::collection($portraits)]);
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

        $thumbnail = null;
        if($request->has('thumbnail')){

            $image = $request->file('thumbnail');

            $fileName = time().'.'.$image->getClientOriginalExtension();
            $image->storeAs('thumbnail', $fileName,'public');
            $thumbnail = '/storage/thumbnail/'. $fileName;
        }

        $portrait = Portrait::create([
            'name' => $request->get('name'),
            'price' => $request->get('price'),
            'thumbnail' => $thumbnail,
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
                'type' => 'position'
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
            'position' => isset($attributes['position']) ? $attributes['position'] : []
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
    public function destroy(Portrait $portrait)
    {
        abort_if($portrait->user_id != auth()->user()->id, 401, "You not have this permission to delete portrait");
        $portrait->delete();

        return response()->json(['status' => true, 'message' => 'Portrait was deleted successfully' ]);

    }
}
