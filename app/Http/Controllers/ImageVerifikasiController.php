<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageVerifikasiRequest;
use App\Models\ImageVerifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImageVerifikasiController extends Controller
{
    public function store(ImageVerifikasiRequest $request)
    {
        $request->validated();
        $user = auth()->user();

        $images = [];

        for ($i = 1; $i <= 4; $i++) {
            $imageName = time().'_'.Str::uuid().'.'.$request->{"image_$i"}->extension();
            $uploadedImage = $request->{"image_$i"}->storeAs('public/verifikasi-image', $imageName);
            $imagePath = 'verifikasi-image/'.$imageName;
            $images["verifikasi-image_$i"] = $imagePath;
        }

        $imageVerifikasiData = ImageVerifikasi::create([
            'id' => 'image-verifikasi-'.Str::uuid(),
            'user_id' => $user->id,
            'image_1' => $images['verifikasi-image_1'],
            'image_2' => $images['verifikasi-image_2'],
            'image_3' => $images['verifikasi-image_3'],
            'image_4' => $images['verifikasi-image_4'],
        ]);

        return response([
            'data' => $imageVerifikasiData,
        ], 201);
    }

    public function showAll()
    {
        $imageVerifikasi = ImageVerifikasi::all();

        return response([
            'data' => $imageVerifikasi,
        ], 200);
    }

    public function delete()
    {
        $user = auth()->user();

        $imageVerifikasi = ImageVerifikasi::where('user_id', $user->id)->first();

        if ($imageVerifikasi) {
            $imageVerifikasi->delete();
            return response([
                'message' => 'Image verifikasi has been deleted',
            ], 200);
        } else {
            return response([
                'message' => 'Image verifikasi not found',
            ], 404);
        }
    }
}
