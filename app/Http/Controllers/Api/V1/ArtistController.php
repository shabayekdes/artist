<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $artists = User::where('type', 3)->get();

        return UserResource::collection($artists);
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
     * @param  \App\Models\User  $artists
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $artist = User::where(['type' => 3, 'id' => $id])->first();

        if($artist == null){
            return response()->json(['status' => false, 'message' => 'Artist not found!!'], 404);

        }

        return new UserResource($artist);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $artist)
    {
        $rating = ($artist->rating + $request->get('rating')) / 2;

// dd($artist->rating == 0 ? $request->get('rating') : $rating);
        $artist->update([
            'rating' => $artist->rating == 0 ? $request->get('rating') : $rating
        ]);

        return response()->json(['status' => true, 'message' => 'Artist has updating rating', 'data' => new UserResource($artist)], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
