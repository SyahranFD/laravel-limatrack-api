<?php

namespace App\Http\Controllers;

use App\Http\Requests\JajananRequest;
use App\Models\Jajanan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class JajananController extends Controller
{
    public function store(JajananRequest $request, $pedagangId)
    {
        $request->validated();
        auth()->user();

        $jajananData = [
            'id' => 'jajanan-'. Str::random(10),
            'pedagang_id' => $pedagangId,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            // 'image' => $request->foto,
            'kategori' => $request->kategori,
        ];

        $jajanan = Jajanan::create($jajananData);

        return response([
            'data' => $jajanan,
        ], 201);
    }
}
