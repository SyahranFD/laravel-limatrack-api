<?php

namespace App\Http\Controllers;

use App\Http\Requests\ZonaTerlarangRequest;
use App\Models\Pedagang;
use App\Models\ZonaTerlarang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ZonaTerlarangController extends Controller
{
    public function store(ZonaTerlarangRequest $request)
    {
        $request->validated();

        $zonaTerlarang = ZonaTerlarang::create([
            'id' => 'zona-terlarang-'.Str::uuid(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius' => $request->radius,
            'nama' => $request->nama,
            'daerah' => $request->daerah
        ]);

        return response([
            'data' => $zonaTerlarang,
        ], 201);
    }

    public function update(ZonaTerlarangRequest $request, $zonaTerlarangId)
    {
        $request->validated();

        $zonaTerlarang = ZonaTerlarang::where('id', $zonaTerlarangId)->first();

        $zonaTerlarang->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius' => $request->radius,
            'nama' => $request->nama,
            'daerah' => $request->daerah
        ]);

        return response([
            'data' => $zonaTerlarang,
        ], 200);
    }

    public function destroy($zonaTerlarangId)
    {
        $zonaTerlarang = ZonaTerlarang::where('id', $zonaTerlarangId)->first();
        $zonaTerlarang->delete();

        return response([
            'message' => 'Zona terlarang deleted',
        ], 200);
    }

    public function index()
    {
        $user = auth()->user();
        $pedagang = Pedagang::where('user_id', $user->id)->first();
        $zonaTerlarang = ZonaTerlarang::where('daerah', $pedagang->daerah_dagang)->get();

        $responseBody = [];

        foreach ($zonaTerlarang as $zona) {
            $jarak = $this->distance($user->latitude, $user->longitude, $zona->latitude, $zona->longitude);

            $responseBody[] = [
                'id' => $zona->id,
                'latitude' => $zona->latitude,
                'longitude' => $zona->longitude,
                'radius' => $zona->radius,
                'nama' => $zona->nama,
                'daerah' => $zona->daerah,
                'jarak' => $jarak,
            ];
        }

        usort($responseBody, function($a, $b) {
            return $a['jarak'] <=> $b['jarak'];
        });

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
