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
        $cart = auth()->user()->cart;

        $cart->load('portraits.portraitAttributes');

        return OrderResource::collection($cart);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
