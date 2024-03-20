<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Pedagang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function registerCustomer(RegisterRequest $request)
    {
        $request->validated();

        $checkEmailExist = User::where('email', $request->email)
            ->where('role', 'customer')
            ->first();
        if ($checkEmailExist) {
            return response([
                'message' => 'Email already exist',
            ], 409);
        }

        $userData = [
            'id' => 'user-'.Str::random(10),
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer',
        ];

        $checkIdExist = User::where('id', $userData['id'])->first();
        while ($checkIdExist) {
            $userData['id'] = 'user-'.Str::random(10);
        }

        $user = User::create($userData);
        $token = $user->createToken('limatrack')->plainTextToken;

        return response([
            'data' => $user,
            'token' => $token,
        ], 201);
    }

    public function loginCustomer(LoginRequest $request)
    {
        $request->validated();

        $user = User::where('email', $request->email)
            ->where('role', 'customer')
            ->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'Email or Password Is Invalid',
            ], 409);
        }

        $token = $user->createToken('limatrack')->plainTextToken;

        return response([
            'data' => $user,
            'token' => $token,
        ], 200);
    }

    public function registerPedagang(RegisterRequest $request)
    {
        $request->validated();

        $checkEmailExist = User::where('email', $request->email)
            ->where('role', 'pedagang')
            ->first();

        if ($checkEmailExist) {
            return response([
                'message' => 'Email already exist',
            ], 409);
        }

        $userData = [
            'id' => 'user-'.uniqid(),
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pedagang',
        ];

        $checkIdExist = User::where('id', $userData['id'])->first();
        while ($checkIdExist) {
            $userData['id'] = 'user-'.Str::random(10);
        }

        $user = User::create($userData);
        $token = $user->createToken('limatrack')->plainTextToken;

        return response([
            'data' => $user,
            'token' => $token,
        ], 201);
    }

    public function loginPedagang(LoginRequest $request)
    {
        $request->validated();

        $user = User::where('email', $request->email)
            ->where('role', 'pedagang')
            ->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'Email or Password Is Invalid',
            ], 409);
        }

        $token = $user->createToken('limatrack')->plainTextToken;

        return response([
            'data' => $user,
            'token' => $token,
        ], 200);
    }

    public function show()
    {
        $user = auth()->user();

        return response([
            'data' => $user,
        ], 200);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $user->update([
            'nama_lengkap' => $request->nama_lengkap,
            'profile_picture' => $request->profile_picture,
        ]);

        Pedagang::where('user_id', $user->id)->update([
            'nama_pedagang' => $request->nama_lengkap,
        ]);

        return response([
            'data' => $user,
        ], 200);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out',
        ];
    }
}
