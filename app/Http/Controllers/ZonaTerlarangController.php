<?php

namespace App\Http\Controllers;

use App\Http\Requests\ZonaTerlarangRequest;
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
        $zonaTerlarang = ZonaTerlarang::all();

        return response([
            'data' => $zonaTerlarang,
        ], 200);
    }
}
