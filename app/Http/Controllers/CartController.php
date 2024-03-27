<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function store(CartRequest $request, $pedagangId, $jajananId)
    {
        $user = auth()->user();

        $cart = Cart::create([
            'id' => 'cart-'.Str::uuid(),
            'user_id' => $user->id,
            'pedagang_id' => $pedagangId,
            'jajanan_id' => $jajananId,
            'jumlah' => $request->jumlah,
            'total_harga' => $request->total_harga,
        ]);

        return response([
            'data' => $cart,
        ], 201);
    }

    public function update(CartRequest $request, $pedagangId, $jajananId, $cartId)
    {
        $user = auth()->user();

        $cart = Cart::where('id', $cartId)->first();

        $cart->update([
            'jumlah' => $request->jumlah,
            'total_harga' => $request->total_harga,
        ]);

        if($cart->jumlah == 0) {
            $cart->delete();
            return response([
                'message' => 'Cart deleted',
            ], 200);
        }

        return response([
            'data' => $cart,
        ], 200);
    }

    public function showAll($pedagangId)
    {
        $user = auth()->user();

        $carts = Cart::where('user_id', $user->id)->get();

        return response([
            'data' => $carts,
        ], 200);
    }
}
