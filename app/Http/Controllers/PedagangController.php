<?php

namespace App\Http\Controllers;

use App\Http\Requests\PedagangRequest;
use App\Models\Pedagang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PedagangController extends Controller
{
    public function store(PedagangRequest $request)
    {
        $request->validated();

        $user = auth()->user();

        $imageName = time().'_'.Str::uuid().'.'.$request->banner->extension();
        $uploadedImage = $request->banner->storeAs('public/banner-pedagang', $imageName);
        $imagePath = 'https://limatrack-api.rplrus.com/storage/banner-pedagang/'.$imageName;

        
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
        
        if ($request->hasFile('dokumen_sertifikat_halal')) {
            $imageNameSertifikat = time().'_'.Str::uuid().'.'.$request->dokumen_sertifikat_halal->extension();
            $uploadedImageSertifikat = $request->dokumen_sertifikat_halal->storeAs('public/sertifikat-halal', $imageNameSertifikat);
            $imagePathSertifikat = 'https://limatrack-api.rplrus.com/storage/sertifikat-halal/'.$imageNameSertifikat;

            $pedagang->update([
                'dokumen_sertifikat_halal' => $imagePathSertifikat,
            ]);
        }
        return response([
            'data' => $pedagang,
        ], 201);
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
            $imagePath = 'https://limatrack-api.rplrus.com/storage/banner/'.$imageName;

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

    public function updateStatus(Request $request)
    {
        $user = auth()->user();

        $pedagang = Pedagang::whereBelongsTo($user)->first();

        $pedagang->update([
            'status' => $request->status
        ]);

        return response([
            'data' => $pedagang,
        ], 200);
    }

    public function updateSertifikat(Request $request)
    {
        $user = auth()->user();

        $pedagang = Pedagang::whereBelongsTo($user)->first();

        Storage::delete('public/'.$pedagang->dokumen_sertifikat_halal);

        $imageName = time().'_'.Str::uuid().'.'.$request->dokumen_sertifikat_halal->extension();
        $uploadedImage = $request->dokumen_sertifikat_halal->storeAs('public/sertifikat-halal', $imageName);
        $imagePath = 'https://limatrack-api.rplrus.com/storage/sertifikat-halal/'.$imageName;

        $pedagang->update([
            'dokumen_sertifikat_halal' => $imagePath,
        ]);

        return response([
            'data' => $pedagang,
        ], 200);
    }

    public function updateSertifikasiByAdmin($id)
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

        $jarak = $this->distance($user->latitude, $user->longitude, $pedagang->latitude, $pedagang->longitude);

        $responseBody = [
            'id' => $pedagang->id,
            'nama_warung' => $pedagang->nama_warung,
            'nama_pedagang' => $pedagang->nama_pedagang,
            'banner' => $pedagang->banner,
            'status' => $pedagang->status,
            'jam_buka' => $pedagang->jam_buka,
            'jam_tutup' => $pedagang->jam_tutup,
            'daerah_dagang' => $pedagang->daerah_dagang,
            'average_rating' => $pedagang->average_rating,
            'sertifikasi_halal' => $pedagang->sertifikasi_halal,
            'latitude' => $pedagang->latitude,
            'longitude' => $pedagang->longitude,
            'jarak' => $jarak,
            'jajanan' => $pedagang->jajanan,
        ];

        return response([
            'data' => $responseBody,
        ], 200);
    }

    public function showAll(Request $request)
    {
        $user = auth()->user();

        $search = $request->query('search');
        $terdekat = $request->query('terdekat');
        $rating = $request->query('rating');
        $sertifikasiHalal = $request->query('sertifikasi_halal');

        $pedagangs = Pedagang::with('jajanan')
            ->when($search, function ($query) use ($search) {
                $query->where('nama_warung', 'like', '%' . $search . '%')
                    ->orWhere('nama_pedagang', 'like', '%' . $search . '%');
            })
            ->when($rating, function ($query) use ($rating) {
                $query->where('average_rating', '>', $rating);
            })
            ->when($sertifikasiHalal, function ($query) use ($sertifikasiHalal) {
                $query->where('sertifikasi_halal', true);
            })
            ->get();

        $responseBody = [];

        foreach ($pedagangs as $pedagang) {
            $jarak = $this->distance($user->latitude, $user->longitude, $pedagang->latitude, $pedagang->longitude);

            $responseBody[] = [
                'id' => $pedagang->id,
                'nama_warung' => $pedagang->nama_warung,
                'nama_pedagang' => $pedagang->nama_pedagang,
                'banner' => $pedagang->banner,
                'status' => $pedagang->status,
                'jam_buka' => $pedagang->jam_buka,
                'jam_tutup' => $pedagang->jam_tutup,
                'daerah_dagang' => $pedagang->daerah_dagang,
                'average_rating' => $pedagang->average_rating,
                'sertifikasi_halal' => $pedagang->sertifikasi_halal,
                'latitude' => $pedagang->latitude,
                'longitude' => $pedagang->longitude,
                'jarak' => $jarak,
                'jajanan' => $pedagang->jajanan,
            ];
        }

        if ($terdekat == 'true') {
            usort($responseBody, function ($a, $b) {
                return $a['jarak'] <=> $b['jarak'];
            });
        }

        return response([
            'data' => $responseBody,
        ], 200);
    }

    function distance($lat1, $lon1, $lat2, $lon2) {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $jarak = ($miles * 1.609344);

        $jarakFormat = number_format($jarak, 2) . ' km';

        return $jarakFormat;
    }
}
