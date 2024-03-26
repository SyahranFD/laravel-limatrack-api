<?php

namespace App\Http\Controllers;

use App\Http\Requests\JajananRequest;
use App\Models\Jajanan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JajananController extends Controller
{
    public function store(JajananRequest $request, $pedagangId)
    {
        $request->validated();
        auth()->user();

        $jajananData = [
            'id' => 'jajanan-'.Str::uuid(),
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

    public function update(JajananRequest $request, $pedagangId, $jajananId)
    {
        $request->validated();
        auth()->user();

        $jajanan = Jajanan::where('pedagang_id', $pedagangId)
            ->where('id', $jajananId)
            ->first();

        $jajanan->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            // 'image' => $request->foto,
            'kategori' => $request->kategori,
        ]);

        return response([
            'data' => $jajanan,
        ], 200);
    }

    public function updateTersedia(Request $request, $pedagangId, $jajananId)
    {
        auth()->user();

        $jajanan = Jajanan::where('pedagang_id', $pedagangId)
            ->where('id', $jajananId)
            ->first();

        if ($jajanan->tersedia == false) {
            $jajanan->update([
                'tersedia' => 1,
            ]);
        } else {
            $jajanan->update([
                'tersedia' => 0,
            ]);
        }

        return response([
            'data' => $jajanan,
        ], 200);
    }

    public function delete($pedagangId, $jajananId)
    {
        auth()->user();

        $jajanan = Jajanan::where('pedagang_id', $pedagangId)
            ->where('id', $jajananId)
            ->first();

        $jajanan->delete();

        return response([
            'message' => 'Jajanan Deleted',
        ], 200);
    }
}
