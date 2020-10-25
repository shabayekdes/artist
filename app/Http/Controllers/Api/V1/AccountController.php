<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PortraitResource;

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
        $user = auth()->user();

        request()->validate([
            // 'name' => 'required',
            'phone' => 'required|unique:users,phone,' . $user->id,
            // 'description' => 'required',
            // 'avatar' => 'required',
            // 'fcm_token' => 'required',
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fcmToken(Request $request)
    {
        $user = auth()->user();

        request()->validate([
            'fcm_token' => 'required',
        ]);

        $user->update([
            'fcm_token' => $request->get('fcm_token')
        ]);

        return response()->json(['status' => true, 'message' => 'Your fcm token has updated'], 200);

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function myPortrait()
    {
        $user = auth()->user();

        if($user->type != 3){
            return response()->json(['status' => false, 'message' => 'sorry not found'], 404);
        }

        return response()->json(['status' => true, 'data' => PortraitResource::collection($user->portraits)], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function myWallet()
    {
        $user = auth()->user();

        return response()->json(['status' => true, 'data' => $user->wallet], 200);
    }
}
