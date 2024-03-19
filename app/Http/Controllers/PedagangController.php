<?php

namespace App\Http\Controllers;

use App\Http\Requests\PedagangRequest;
use App\Models\Pedagang;
use Illuminate\Http\Request;

class PedagangController extends Controller
{
    public function store(PedagangRequest $request)
    {
        $request->validated();

        $pedagang = Pedagang::create($request->all());

        return response([
            'data' => $pedagang,
        ], 201);
    }

    public function update(PedagangRequest $request)
    {
        
    }
}
