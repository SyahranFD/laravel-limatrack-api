<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Otp;
use App\Models\Pedagang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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

        $checkOtp = Otp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();
        if (! $checkOtp) {
            return response([
                'message' => 'OTP is invalid',
            ], 409);
        }

        $userData = [
            'id' => 'user-'.Str::uuid(),
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer',
            'otp' => $request->otp,
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
            'id' => 'user-'.Str::uuid(),
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

        if ($request->hasFile('profile_picture')) {
            Storage::delete('public/'.$user->profile_picture);

            $imageName = time().'_'.Str::uuid().'.'.$request->profile_picture->extension();
            $uploadedImage = $request->profile_picture->storeAs('public/profile_picture', $imageName);
            $imagePath = 'profile_picture/'.$imageName;

            $user->update([
                'nama_lengkap' => $request->nama_lengkap,
                'profile_picture' => $imagePath,
            ]);

            Pedagang::where('user_id', $user->id)->update([
                'nama_pedagang' => $request->nama_lengkap,
            ]);

            return response([
                'data' => $user,
            ], 200);

        } else {
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
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out',
        ];
    }

    public function updateLocation(Request $request)
    {
        $user = auth()->user();

        $user->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        $pedagang = Pedagang::where('user_id', $user->id)
            ->first();

        if ($user->role == 'pedagang') {
            $pedagang->update([
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
        }

        return response([
            'data' => $user,
        ], 200);
    }

    public function updateProfilePicture(Request $request)
    {
        $user = auth()->user();

        if ($request->hasFile('profile_picture')) {
            $imageName = time().'.'.$request->profile_picture->extension();
            $uploadedImage = $request->profile_picture->storeAs('public/profile_picture', $imageName);
            $imagePath = 'profile_picture/'.$imageName;

            $user->update([
                'profile_picture' => $imagePath,
            ]);

            return response([
                'data' => $user,
            ], 200);
        } else {
            return response([
                'error' => 'No file found for profile_picture',
            ], 400);
        }
    }
}
