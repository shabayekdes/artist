<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        return new UserResource($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd(setting('site.WHAT'));
        $user = auth()->user();

        request()->validate([
            'name' => 'required',
            'phone' => 'required|unique:users,phone,' . $user->id,
            'description' => 'required',
            'avatar' => 'required',
        ]);

        $data = $request->all();

        if($request->has('avatar')){

            $imageUrl = Str::replaceFirst('/storage', 'public', $user->avatar);
            Storage::delete($imageUrl);

            $image = $request->file('avatar');

            $fileName = time().'.'.$image->getClientOriginalExtension();
            $request['avatar']->storeAs('avatar', $fileName,'public');
            $data['avatar'] = '/storage/avatar/'. $fileName;
        }

        $user->update($data);

        return response()->json(['status' => true, 'message' => 'Your account has updated'], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
