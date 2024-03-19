<?php

namespace App\Http\Controllers;

use App\Http\Requests\PedagangRequest;
use Illuminate\Support\Str;
use App\Models\Pedagang;
use Illuminate\Http\Request;

class PedagangController extends Controller
{
    public function store(PedagangRequest $request)
    {
        $request->validated();

        $user = auth()->user();

        $pedagang = auth()->user()->pedagang()->create([
            'id' => 'pedagang-'. Str::random(10),
            'user_id' => $user->id,
            'nama_pedagang' => $user->nama_lengkap,
            'nama_warung' => $request->nama_warung,
            'jam_buka' => $request->jam_buka,
            'jam_tutup' => $request->jam_tutup,
            'daerah_dagang' => $request->daerah_dagang
        ]);

        // $pedagangData = [
        //     'id' => 'pedagang-'. Str::random(10),
        //     'user_id' => $user->id,
        //     'nama_pedagang' => $user->nama_lengkap,
        //     'nama_warung' => $request->nama_warung,
        //     'jam_buka' => $request->jam_buka,
        //     'jam_tutup' => $request->jam_tutup,
        //     'daerah_dagang' => $request->daerah_dagang
        // ];

        // $pedagang = Pedagang::create($pedagangData);

        return response([
            'data' => $pedagang,
        ], 201);
    }

    public function update(PedagangRequest $request)
    {

    }
}
