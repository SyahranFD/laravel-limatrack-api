<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function store(OrderRequest $request, $pedagangId)
    {
        $request->validated();
        $user = auth()->user();

        $order = Order::create([
            'id' => 'order-'.Str::uuid(),
            'user_id' => $user->id,
            'pedagang_id' => $pedagangId,
            'status' => $request->status,
            'metode_pembayaran' => $request->metode_pembayaran,
            'total_keseluruhan' => 0,
        ]);

        $carts = Cart::where('user_id', $user->id)->get();

        $orderItem = [];

        foreach ($carts as $cart) {
            $orderItem[] = [
                'id' => 'order-item-'.Str::uuid(),
                'order_id' => $order->id,
                'pedagang_id' => $cart->pedagang_id,
                'jajanan_id' => $cart->jajanan_id,
                'nama_warung' => $cart->nama_warung,
                'jumlah' => $cart->jumlah,
                'total_harga' => $cart->total_harga,
            ];

            $order->total_keseluruhan += $cart->total_harga;
            $cart->delete();
        }

        OrderItem::insert($orderItem);

        return response([
            'data' => $order,
        ], 201);
    }

    public function showCurrent()
    {
        $user = auth()->user();

        $orders = Order::whereBelongsTo($user)->with('orderItem')->get();

        return response([
            'data' => $orders,
        ], 200);
    }

    public function showByPedagangId($pedagangId)
    {
        $orders = Order::where('pedagang_id', $pedagangId)->with('orderItem')->get();

        return response([
            'data' => $orders,
        ], 200);
    }
}
