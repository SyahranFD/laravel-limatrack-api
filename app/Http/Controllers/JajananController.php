<?php

namespace App\Http\Controllers;

use App\Http\Requests\JajananRequest;
use App\Models\Jajanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class JajananController extends Controller
{
    public function store(JajananRequest $request, $pedagangId)
    {
        $request->validated();
        auth()->user();

        $imageName = time().'_'.Str::uuid().'.'.$request->image->extension();
        $uploadedImage = $request->image->storeAs('public/jajanan', $imageName);
        $imagePath = 'jajanan/'.$imageName;

        $jajanan = Jajanan::create([
            'id' => 'jajanan-'.Str::uuid(),
            'pedagang_id' => $pedagangId,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'kategori' => $request->kategori,
            'image' => $imagePath,
        ]);

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

        if ($request->hasFile('image')) {
            Storage::delete('public/'.$jajanan->image);

            $imageName = time().'_'.Str::uuid().'.'.$request->image->extension();
            $uploadedImage = $request->image->storeAs('public/jajanan', $imageName);
            $imagePath = 'jajanan/'.$imageName;

            $jajanan->update([
                'pedagang_id' => $pedagangId,
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'harga' => $request->harga,
                'image' => $imagePath,
                'kategori' => $request->kategori,
            ]);

            return response([
                'data' => $jajanan,
            ], 201);

        } else {
            $jajanan->update([
                'pedagang_id' => $pedagangId,
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'harga' => $request->harga,
                'image' => $request->image,
                'kategori' => $request->kategori,
            ]);

            return response([
                'data' => $jajanan,
            ], 201);
        }
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
