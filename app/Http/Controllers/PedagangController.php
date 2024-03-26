<?php

namespace App\Http\Controllers;

use App\Http\Requests\PedagangRequest;
use App\Models\Pedagang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PedagangController extends Controller
{
    public function store(PedagangRequest $request)
    {
        $request->validated();

        $user = auth()->user();

        if ($request->hasFile('banner')) {
            $imageName = time().'.'.$request->banner->extension();
            $uploadedImage = $request->banner->storeAs('public/banner', $imageName);
            $imagePath = 'banner/'.$imageName;

            $pedagangData = [
                'id' => 'pedagang-'.Str::random(10),
                'user_id' => $user->id,
                'nama_pedagang' => $user->nama_lengkap,
                'nama_warung' => $request->nama_warung,
                'banner' => $imagePath,
                'jam_buka' => $request->jam_buka,
                'jam_tutup' => $request->jam_tutup,
                'daerah_dagang' => $request->daerah_dagang,
            ];

            $pedagang = Pedagang::create($pedagangData);

            return response([
                'data' => $pedagang,
            ], 201);

        } else {
            return response([
                'error' => 'No file found for banner',
            ], 400);
        }
    }

    public function update(PedagangRequest $request)
    {
        $request->validated();

        $user = auth()->user();

        $pedagang = Pedagang::whereBelongsTo($user)->first();

        if ($request->hasFile('banner')) {
            Storage::delete('public/'.$pedagang->banner);

            $imageName = time().'.'.$request->banner->extension();
            $uploadedImage = $request->banner->storeAs('public/banner', $imageName);
            $imagePath = 'banner/'.$imageName;

            $pedagangData = [
                'nama_warung' => $request->nama_warung,
                'banner' => $imagePath,
                'jam_buka' => $request->jam_buka,
                'jam_tutup' => $request->jam_tutup,
                'daerah_dagang' => $request->daerah_dagang,
            ];

            $pedagang->update($pedagangData);

            return response([
                'data' => $pedagang,
            ], 201);

        } else {
            $pedagang->update([
                'nama_warung' => $request->nama_warung,
                'jam_buka' => $request->jam_buka,
                'jam_tutup' => $request->jam_tutup,
                'daerah_dagang' => $request->daerah_dagang,
                'banner' => $request->banner,
            ]);

            return response([
                'data' => $pedagang,
            ], 200);
        }
    }

    public function updateBuka()
    {
        $user = auth()->user();

        $pedagang = Pedagang::whereBelongsTo($user)->first();

        if ($pedagang->buka == false) {
            $pedagang->update([
                'buka' => true,
            ]);
        } else {
            $pedagang->update([
                'buka' => false,
            ]);
        }

        return response([
            'data' => $pedagang,
        ], 200);
    }

    public function updateSertifikasi($id)
    {
        $pedagang = Pedagang::where('id', $id)->first();

        if ($pedagang->sertifikasi_halal == false) {
            $pedagang->update([
                'sertifikasi_halal' => true,
            ]);
        } else {
            $pedagang->update([
                'sertifikasi_halal' => false,
            ]);
        }

        return response([
            'data' => $pedagang,
        ], 200);
    }

    public function show()
    {
        $user = auth()->user();

        $pedagang = Pedagang::whereBelongsTo($user)->with('jajanan')->first();

        return response([
            'data' => $pedagang,
        ], 200);

    }

    public function showById($id)
    {
        $pedagang = Pedagang::where('id', $id)->with('jajanan')->first();

        return response([
            'data' => $pedagang,
        ], 200);
    }

    public function showAll()
    {
        $pedagang = Pedagang::with('jajanan')->get();

        return response([
            'data' => $pedagang,
        ], 200);
    }
}
