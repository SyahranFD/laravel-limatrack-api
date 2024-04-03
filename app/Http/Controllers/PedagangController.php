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
            $imageName = time().'_'.Str::uuid().'.'.$request->banner->extension();
            $uploadedImage = $request->banner->storeAs('public/banner-pedagang', $imageName);
            $imagePath = 'banner-pedagang/'.$imageName;

            $pedagang = Pedagang::create([
                'id' => 'pedagang-'.Str::uuid(),
                'user_id' => $user->id,
                'nama_pedagang' => $user->nama_lengkap,
                'nama_warung' => $request->nama_warung,
                'banner' => $imagePath,
                'jam_buka' => $request->jam_buka,
                'jam_tutup' => $request->jam_tutup,
                'daerah_dagang' => $request->daerah_dagang,
                'latitude' => $user->latitude,
                'longitude' => $user->longitude,
            ]);

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

            $imageName = time().'_'.Str::uuid().'.'.$request->banner->extension();
            $uploadedImage = $request->banner->storeAs('public/banner', $imageName);
            $imagePath = 'banner/'.$imageName;

            $pedagang->update([
                'nama_warung' => $request->nama_warung,
                'banner' => $imagePath,
                'jam_buka' => $request->jam_buka,
                'jam_tutup' => $request->jam_tutup,
                'daerah_dagang' => $request->daerah_dagang,
            ]);

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

    public function showCurrent()
    {
        $user = auth()->user();

        $pedagang = Pedagang::whereBelongsTo($user)->with('jajanan')->first();

        return response([
            'data' => $pedagang,
        ], 200);
    }

    public function showById($id)
    {
        $user = auth()->user();

        $pedagang = Pedagang::where('id', $id)->with('jajanan')->first();

        $theta = $user->longitude - $pedagang->longitude;
        $dist = sin(deg2rad($user->latitude)) * sin(deg2rad($pedagang->latitude)) + cos(deg2rad($user->latitude)) * cos(deg2rad($pedagang->latitude)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $jarak = ($miles * 1.609344);

        if (is_nan($jarak)) {
            $jarak = 0;
        }

        $jarakFormat = number_format($jarak, 2) . ' km';

        $responseBody = [
            'id' => $pedagang->id,
            'nama_warung' => $pedagang->nama_warung,
            'nama_pedagang' => $pedagang->nama_pedagang,
            'banner' => $pedagang->banner,
            'buka' => $pedagang->buka,
            'jam_buka' => $pedagang->jam_buka,
            'jam_tutup' => $pedagang->jam_tutup,
            'daerah_dagang' => $pedagang->daerah_dagang,
            'average_rating' => $pedagang->average_rating,
            'sertifikasi_halal' => $pedagang->sertifikasi_halal,
            'latitude' => $pedagang->latitude,
            'longitude' => $pedagang->longitude,
            'jarak' => $jarakFormat,
            'jajanan' => $pedagang->jajanan,
        ];

        return response([
            'data' => $responseBody,
        ], 200);
    }

    public function showAll()
    {
        $user = auth()->user();

        $pedagangs = Pedagang::with('jajanan')->get();

        $responseBody = [];

        foreach ($pedagangs as $pedagang) {
            $theta = $user->longitude - $pedagang->longitude;
            $dist = sin(deg2rad($user->latitude)) * sin(deg2rad($pedagang->latitude)) + cos(deg2rad($user->latitude)) * cos(deg2rad($pedagang->latitude)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $jarak = ($miles * 1.609344);

            if (is_nan($jarak)) {
                $jarak = 0;
            }

            $jarakFormat = number_format($jarak, 2) . ' km';

            $responseBody[] = [
                'id' => $pedagang->id,
                'nama_warung' => $pedagang->nama_warung,
                'nama_pedagang' => $pedagang->nama_pedagang,
                'banner' => $pedagang->banner,
                'buka' => $pedagang->buka,
                'jam_buka' => $pedagang->jam_buka,
                'jam_tutup' => $pedagang->jam_tutup,
                'daerah_dagang' => $pedagang->daerah_dagang,
                'average_rating' => $pedagang->average_rating,
                'sertifikasi_halal' => $pedagang->sertifikasi_halal,
                'latitude' => $pedagang->latitude,
                'longitude' => $pedagang->longitude,
                'jarak' => $jarakFormat,
                'jajanan' => $pedagang->jajanan,
            ];
        }

        return response([
            'data' => $responseBody,
        ], 200);
    }
}
