<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Models\Jajanan;
use App\Models\Pedagang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function store(CartRequest $request, $pedagangId, $jajananId)
    {
        $user = auth()->user();

        $nama_warung = Pedagang::where('id', $pedagangId)->first()->nama_warung;

        $cart = Cart::create([
            'id' => 'cart-'.Str::uuid(),
            'user_id' => $user->id,
            'pedagang_id' => $pedagangId,
            'jajanan_id' => $jajananId,
            'nama_warung' => $nama_warung,
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

    public function showCurrent()
    {
        $user = auth()->user();

        $carts = Cart::where('user_id', $user->id)->get();
        $total_keseluruhan = $carts->sum('total_harga');

        $responseBody = [];

        foreach ($carts as $cart) {
            $jajanan = Jajanan::where('id', $cart->jajanan_id)->first();

            $responseBody[] = [
                'id' => $cart->id,
                'nama_warung' => $cart->nama_warung,
                'nama_jajanan' => $jajanan->nama,
                'harga' => $jajanan->harga,
                'image' => $jajanan->image,
                'jumlah' => $cart->jumlah,
                'total_harga' => $cart->total_harga,
            ];
        }

        return response([
            'data' => $responseBody,
            'total_keseluruhan' => $total_keseluruhan,
        ], 200);
    }
}
