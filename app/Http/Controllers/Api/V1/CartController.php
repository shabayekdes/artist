<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\CartPortrait;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = auth()->user()->cart()->first();

        if($cart != null){

            $cart->load('portraits.portraitAttributes', 'portraits.portrait');
            return new OrderResource($cart);
        }

        return response()->json(['status' => false, 'data' => []]);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'quantity' => 'required|integer',
            'total' => 'required|integer',
            'portrait_id' => 'required|exists:portraits,id',
            'attributes' => 'required|array',
        ]);

        $cart = Cart::where("user_id", auth()->user()->id)->first();

        if($cart == null){
            $cart = Cart::create([
                "user_id" => auth()->user()->id
            ]);   
        }

        $cart->update([
            "item_count" => $cart->item_count + $request->get('quantity'),
            "grand_total" => $cart->grand_total + $request->get('total'),
        ]);  


        $cartProtrait = CartPortrait::where("portrait_id", $request->get('portrait_id'))->first();

        if($cartProtrait == null){
            $cartProtrait = CartPortrait::create([
                "cart_id" => $cart->id,
                "portrait_id" => $request->get('portrait_id'),
                "quantity" => $request->get('quantity'),
                "total" => $request->get('total'),
            ]);
            
        }else{
            $cartProtrait->update([
                "quantity" => $cartProtrait->quantity + $request->get('quantity'),
                "total" => $cartProtrait->total + $request->get('total'),
            ]);
        }

        $cartProtrait->portraitAttributes()->sync($request->get('attributes'));
    
        return response()->json(['status' => true, 'message' => 'Cart was added!!']);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $cart = Cart::where("user_id", auth()->user()->id)->first();
        $cartPortrait = CartPortrait::where([
                ["cart_id", $cart->id],
                ["portrait_id", $request->get('portrait_id')]
            ])->update([
                'quantity' => $request->get('quantity')
            ]);


        return response()->json(['status' => true, 'message' => 'Cart has updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();

        return response()->json(['status' => true, 'message' => 'Cart was deleted!!']);

    }
}
