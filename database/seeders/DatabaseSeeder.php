<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Pedagang;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'id' => 'user-'.fake()->uuid(),
            'nama_lengkap' => 'Rafa Syahran',
            'email' => 'fadhilrafa1@gmail.com',
            'password' => Hash::make('rafapass'),
            'role' => 'customer',
            'latitude' => '-6.753818894951011',
            'longitude' => '110.84275218710701',
        ]);

        User::create([
            'id' => 'user-'.fake()->uuid(),
            'nama_lengkap' => 'Rafa Syahran',
            'email' => 'fadhilrafa1@gmail.com',
            'password' => Hash::make('rafapass'),
            'role' => 'pedagang',
            'latitude' => '-6.754239742962566',
            'longitude' => '110.84305125340968',
        ]);

        User::create([
            'id' => 'user-'.fake()->uuid(),
            'nama_lengkap' => 'Rio Hermawan',
            'email' => 'rio@gmail.com',
            'password' => Hash::make('riopass'),
            'role' => 'customer',
        ]);

        User::create([
            'id' => 'user-'.fake()->uuid(),
            'nama_lengkap' => 'Rio Hermawan',
            'email' => 'rio@gmail.com',
            'password' => Hash::make('riopass'),
            'role' => 'pedagang',
        ]);

        User::factory()
        ->has(
            Pedagang::factory()
                ->state(function (array $attributes, User $user) {
                    return [
                        'nama_warung' => 'Batagor Pak Riot',
                        'nama_pedagang' => $user->nama_lengkap,
                        'banner' => 'https://kuninganmass.com/wp-content/uploads/2021/09/IMG-20210909-WA0056.jpg',
                        'latitude' => $user->latitude,
                        'longitude' => $user->longitude,
                    ];
                })
        )
        ->create([
            'role' => 'pedagang',
            'latitude' => '-6.75392669750156',
            'longitude' => '110.84386271712118',
        ]);

        User::factory()
        ->has(
            Pedagang::factory()
                ->state(function (array $attributes, User $user) {
                    return [
                        'nama_warung' => 'Cilor Mas Pri',
                        'nama_pedagang' => $user->nama_lengkap,
                        'banner' => 'https://kuninganmass.com/wp-content/uploads/2021/09/IMG-20210909-WA0056.jpg',
                        'latitude' => $user->latitude,
                        'longitude' => $user->longitude,
                    ];
                })
        )
        ->create([
            'role' => 'pedagang',
            'latitude' => '-6.75192669750156',
            'longitude' => '110.84186271712118',
        ]);

        User::factory()
        ->has(
            Pedagang::factory()
                ->state(function (array $attributes, User $user) {
                    return [
                        'nama_warung' => 'Siomay Pak Fuad',
                        'nama_pedagang' => $user->nama_lengkap,
                        'banner' => 'https://kuninganmass.com/wp-content/uploads/2021/09/IMG-20210909-WA0056.jpg',
                        'latitude' => $user->latitude,
                        'longitude' => $user->longitude,
                    ];
                })
        )
        ->create([
            'role' => 'pedagang',
            'latitude' => '-6.75392669750156',
            'longitude' => '110.84186271712118',
        ]);

        User::factory()
            ->has(
                Pedagang::factory()
                    ->state(function (array $attributes, User $user) {
                        return [
                            'nama_warung' => 'Siomay Pak Somad',
                            'nama_pedagang' => $user->nama_lengkap,
                            'banner' => 'https://kuninganmass.com/wp-content/uploads/2021/09/IMG-20210909-WA0056.jpg',
                            'latitude' => $user->latitude,
                            'longitude' => $user->longitude,
                        ];
                    })
            )
            ->create([
                'role' => 'pedagang',
                'latitude' => '-6.75392669750156',
                'longitude' => '110.84286271712118',
            ]);
    }
}
