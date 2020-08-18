<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use App\Http\Requests\UserAddressStoreRequest;

class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $addresses = auth()->user()->addresses()->get();

        if($addresses->isEmpty()){
            return response()->json(['status' => false, 'message' => 'Sorry, don\'t have any addresses'], 404);
        }

        return UserAddress::collection($addresses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserAddressStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserAddressStoreRequest $request)
    {
        $data = auth()->user()->addresses()->create($request->all());

        return response()->json(['status' => true, 'message' => 'Address was added!!']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserAddress  $userAddress
     * @return \Illuminate\Http\Response
     */
    public function show(UserAddress $userAddress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserAddress  $userAddress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserAddress $userAddress)
    {
        $userAddress->update($request->all());

        return response()->json(['status' => true, 'message' => 'Address was updated!!']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserAddress  $userAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAddress $userAddress)
    {
        $userAddress->delete();

        return response()->json(['status' => true, 'message' => 'Address was deleted!!']);

    }
}
