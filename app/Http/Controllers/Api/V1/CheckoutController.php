<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProtrait;
use Illuminate\Http\Request;
use App\Http\Requests\CheckoutStoreRequest;

class CheckoutController extends Controller
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
     * @param  CheckoutStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CheckoutStoreRequest $request)
    {

        $order = Order::create([
            "item_count" => $request->get('item_count'),
            "grand_total" => $request->get('grand_total'),
            "payment_method" => $request->get('payment_method'),
            "payment_status" => $request->get('payment_status'),
            "user_address_id" => $request->get('user_address_id'),
            "user_id" => auth()->user()->id,
            "profit" => $request->get('grand_total') * setting('site.profit') / 100
        ]);

        $order->update([
            'key' => 'OR' . sprintf('%05u', $order->id)
        ]);

        $details = $request->input('details');

        foreach ($details as $key => $detail) {
            $orderProtrait = OrderProtrait::create([
                "order_id" => $order->id,
                "portrait_id" => $detail['portrait_id'],
                "quantity" => $detail['quantity'],
                "total" => $detail['total'],
            ]);

            $orderProtrait->portraitAttributes()->sync($detail['attributes']);
        }

        return response()->json(['status' => true, 'message' => 'Order was added!!', 'data' => ['order_id' => $order->key]]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
