<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Pedagang;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()
            ->has(
                Pedagang::factory()
                            ->state(function (array $attributes, User $user) {
                                return [
                                    'nama_warung' => 'Siomay Pak Somad',
                                    'nama_pedagang' => $user->nama_lengkap,
                                    // 'image' => 'https://via.placeholder.com/150',
                                    'latitude' => $user->latitude,
                                    'longitude' => $user->longitude,
                                ];
                            })
            )
            ->create([
                'role' => 'pedagang',
                'latitude' => '-6.75392669750156',
                'longitude' => '110.84286271712118'
            ]);
    }
}
