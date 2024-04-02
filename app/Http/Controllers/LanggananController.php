<?php

namespace App\Http\Controllers;

use App\Models\Langganan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LanggananController extends Controller
{
    public function store(Request $request)
    {
        $user = auth()->user();

        $langganan = Langganan::create([
            'id' => 'langganan-'.Str::uuid(),
            'user_id' => $user->id,
            'pedagang_id' => $request->pedagang_id,
        ]);

        return response([
            'data' => $langganan,
        ], 201);
    }

    public function showCurrent()
    {
        $user = auth()->user();

        $langganan = Langganan::where('user_id', $user->id)->with('pedagang')->get();

        return response([
            'data' => $langganan,
        ], 200);
    }

    public function delete($pedagangId)
    {
        $user = auth()->user();

        $langganan = Langganan::where('pedagang_id', $pedagangId)->first();

        $langganan->delete();

        return response([
            'message' => 'Langganan berhasil dihapus',
        ], 200);
    }
}
