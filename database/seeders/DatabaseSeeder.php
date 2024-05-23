<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Pedagang;
use App\Models\User;
use App\Models\ZonaTerlarang;
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

        $rio = User::create([
            'id' => 'user-'.fake()->uuid(),
            'nama_lengkap' => 'Rio Hermawan',
            'email' => 'rio@gmail.com',
            'password' => Hash::make('riopass'),
            'role' => 'pedagang',
            'latitude' => '-6.98181012492886',
            'longitude' => '110.45279892197568',
        ]);

        $pedagangRio = $rio->pedagang()->create([
            'id' => 'pedagang-'.fake()->uuid(),
            'user_id' => $rio->id,
            'nama_warung' => 'Siomay Batagor Rio',
            'nama_pedagang' => $rio->nama_lengkap,
            'jam_buka' => '12:00',
            'jam_tutup' => '16:00',
            'daerah_dagang' => 'Semarang',
            'banner' => 'https://www.niaga.asia/wp-content/uploads/2022/10/Screenshot_20221010-185531_Gallery-e1665399482853.jpg',
            'latitude' =>  $rio->latitude,
            'longitude' => $rio->longitude,
        ]);

        $pedagangRio->jajanan()->create([
            'id' => 'jajanan-'.fake()->uuid(),
            'nama' => 'Siomay 5000',
            'harga' => 5000,
            'deskripsi' => 'Paket lengkap isi siomay, telur, tahu putih, kol, pare, dan bumbu kacang. Jika ada yang mau dirubah, tolong isi di catatan ya.',
            'image' => 'https://i0.wp.com/resepkoki.id/wp-content/uploads/2020/03/Resep-Siomay-Bandung.jpg?fit=1859%2C1920&ssl=1',
            'kategori' => 'Jajanan Utama'
        ]);

        $pedagangRio->jajanan()->create([
            'id' => 'jajanan-'.fake()->uuid(),
            'nama' => 'Siomay 3000',
            'harga' => 3000,
            'deskripsi' => 'Paket lengkap isi siomay, telur, tahu putih, kol, pare, dan bumbu kacang. Jika ada yang mau dirubah, tolong isi di catatan ya.',
            'image' => 'https://i0.wp.com/resepkoki.id/wp-content/uploads/2020/03/Resep-Siomay-Bandung.jpg?fit=1859%2C1920&ssl=1',
            'kategori' => 'Lainnya'
        ]);

        $pedagangRio->jajanan()->create([
            'id' => 'jajanan-'.fake()->uuid(),
            'nama' => 'Siomay 2000',
            'harga' => 2000,
            'deskripsi' => 'Paket lengkap isi siomay, telur, tahu putih, kol, pare, dan bumbu kacang. Jika ada yang mau dirubah, tolong isi di catatan ya.',
            'image' => 'https://i0.wp.com/resepkoki.id/wp-content/uploads/2020/03/Resep-Siomay-Bandung.jpg?fit=1859%2C1920&ssl=1',
            'kategori' => 'Lainnya'
        ]);
        
        $pedagangRio->jajanan()->create([
            'id' => 'jajanan-'.fake()->uuid(),
            'nama' => 'Batagor 5000',
            'harga' => 5000,
            'deskripsi' => 'Jika ada yang mau dirubah, tolong isi di catatan ya.',
            'image' => 'https://cdn0-production-images-kly.akamaized.net/hjyQ1Kv6CwzCSNmNNYcevSRv-Ok=/1200x675/smart/filters:quality(75):strip_icc():format(jpeg)/kly-media-production/medias/1364565/original/091028300_1475593576-batagor.jpg',
            'kategori' => 'Jajanan Utama'
        ]);

        $pedagangRio->jajanan()->create([
            'id' => 'jajanan-'.fake()->uuid(),
            'nama' => 'Batagor 3000',
            'harga' => 3000,
            'deskripsi' => 'Jika ada yang mau dirubah, tolong isi di catatan ya.',
            'image' => 'https://cdn0-production-images-kly.akamaized.net/hjyQ1Kv6CwzCSNmNNYcevSRv-Ok=/1200x675/smart/filters:quality(75):strip_icc():format(jpeg)/kly-media-production/medias/1364565/original/091028300_1475593576-batagor.jpg',
            'kategori' => 'Lainnya'
        ]);

        $pedagangRio->jajanan()->create([
            'id' => 'jajanan-'.fake()->uuid(),
            'nama' => 'Batagor 2000',
            'harga' => 2000,
            'deskripsi' => 'Jika ada yang mau dirubah, tolong isi di catatan ya.',
            'image' => 'https://cdn0-production-images-kly.akamaized.net/hjyQ1Kv6CwzCSNmNNYcevSRv-Ok=/1200x675/smart/filters:quality(75):strip_icc():format(jpeg)/kly-media-production/medias/1364565/original/091028300_1475593576-batagor.jpg',
            'kategori' => 'Lainnya'
        ]);

        User::factory()
        ->has(
            Pedagang::factory()
                ->state(function (array $attributes, User $user) {
                    return [
                        'nama_warung' => 'Batagor Pak Riot',
                        'nama_pedagang' => $user->nama_lengkap,
                        'banner' => 'https://titiknol.co.id/images/post/2021/12/titiknol_q4_img_20211206_141340.jpg',
                        'latitude' => $user->latitude,
                        'longitude' => $user->longitude,
                    ];
                })
                ->afterCreating(function (Pedagang $pedagang) {
                    $pedagang->jajanan()->create([
                        'id' => 'jajanan-'.fake()->uuid(),
                        'nama' => 'Batagor 5000',
                        'harga' => 5000,
                        'deskripsi' => 'Jika ada yang mau dirubah, tolong isi di catatan ya.',
                        'image' => 'https://cdn0-production-images-kly.akamaized.net/hjyQ1Kv6CwzCSNmNNYcevSRv-Ok=/1200x675/smart/filters:quality(75):strip_icc():format(jpeg)/kly-media-production/medias/1364565/original/091028300_1475593576-batagor.jpg',
                        'kategori' => 'Jajanan Utama'
                    ]);
            
                    $pedagang->jajanan()->create([
                        'id' => 'jajanan-'.fake()->uuid(),
                        'nama' => 'Batagor 3000',
                        'harga' => 3000,
                        'deskripsi' => 'Jika ada yang mau dirubah, tolong isi di catatan ya.',
                        'image' => 'https://cdn0-production-images-kly.akamaized.net/hjyQ1Kv6CwzCSNmNNYcevSRv-Ok=/1200x675/smart/filters:quality(75):strip_icc():format(jpeg)/kly-media-production/medias/1364565/original/091028300_1475593576-batagor.jpg',
                        'kategori' => 'Lainnya'
                    ]);
            
                    $pedagang->jajanan()->create([
                        'id' => 'jajanan-'.fake()->uuid(),
                        'nama' => 'Batagor 2000',
                        'harga' => 2000,
                        'deskripsi' => 'Jika ada yang mau dirubah, tolong isi di catatan ya.',
                        'image' => 'https://cdn0-production-images-kly.akamaized.net/hjyQ1Kv6CwzCSNmNNYcevSRv-Ok=/1200x675/smart/filters:quality(75):strip_icc():format(jpeg)/kly-media-production/medias/1364565/original/091028300_1475593576-batagor.jpg',
                        'kategori' => 'Lainnya'
                    ]);
                })
        )
        ->create([
            'role' => 'pedagang',
            'latitude' => '-6.980665809401963',
            'longitude' => '110.45376560820476',
        ]);

        User::factory()
        ->has(
            Pedagang::factory()
                ->state(function (array $attributes, User $user) {
                    return [
                        'nama_warung' => 'Cilor Mas Pri',
                        'nama_pedagang' => $user->nama_lengkap,
                        'banner' => 'https://static.promediateknologi.id/crop/0x0:0x0/750x500/webp/photo/ayobandung/images-bandung/post/articles/2019/06/17/55235/f192dfce-05aa-4fef-9d7f-129360be96a3-600x641.jpg',
                        'latitude' => $user->latitude,
                        'longitude' => $user->longitude,
                    ];
                })
                ->afterCreating(function (Pedagang $pedagang) {
                    $pedagang->jajanan()->create([
                        'id' => 'jajanan-'.fake()->uuid(),
                        'nama' => 'Cilor 5000 Pedas',
                        'harga' => 5000,
                        'deskripsi' => 'Jika ada yang mau dirubah, tolong isi di catatan ya.',
                        'image' => 'https://img-global.cpcdn.com/recipes/7cdf863c42e33575/680x482cq70/cilor-pedas-asin-foto-resep-utama.jpg',
                        'kategori' => 'Jajanan Utama'
                    ]);

                    $pedagang->jajanan()->create([
                        'id' => 'jajanan-'.fake()->uuid(),
                        'nama' => 'Cilor 3000 Pedas',
                        'harga' => 3000,
                        'deskripsi' => 'Jika ada yang mau dirubah, tolong isi di catatan ya.',
                        'image' => 'https://img-global.cpcdn.com/recipes/7cdf863c42e33575/680x482cq70/cilor-pedas-asin-foto-resep-utama.jpg',
                        'kategori' => 'Lainnya'
                    ]);

                    $pedagang->jajanan()->create([
                        'id' => 'jajanan-'.fake()->uuid(),
                        'nama' => 'Cilor 5000 Asin',
                        'harga' => 5000,
                        'deskripsi' => 'Jika ada yang mau dirubah, tolong isi di catatan ya.',
                        'image' => 'https://img-global.cpcdn.com/recipes/8283aaacae6aac86/1200x630cq70/photo.jpg',
                        'kategori' => 'Jajanan Utama'
                    ]);

                    $pedagang->jajanan()->create([
                        'id' => 'jajanan-'.fake()->uuid(),
                        'nama' => 'Cilor 3000 Asin',
                        'harga' => 3000,
                        'deskripsi' => 'Jika ada yang mau dirubah, tolong isi di catatan ya.',
                        'image' => 'https://img-global.cpcdn.com/recipes/8283aaacae6aac86/1200x630cq70/photo.jpg',
                        'kategori' => 'Lainnya'
                    ]);
                })
        )
        ->create([
            'role' => 'pedagang',
            'latitude' => '-6.983199647199585',
            'longitude' => '110.4518393963762',
        ]);

        User::factory()
        ->has(
            Pedagang::factory()
                ->state(function (array $attributes, User $user) {
                    return [
                        'nama_warung' => 'Siomay Pak Fuad',
                        'nama_pedagang' => $user->nama_lengkap,
                        'banner' => 'https://www.infopublik.id/resources/album/september-2020/PENJUAL_SIOMAY.JPG',
                        'latitude' => $user->latitude,
                        'longitude' => $user->longitude,
                    ];
                })
                ->afterCreating(function (Pedagang $pedagang) {
                    $pedagang->jajanan()->create([
                        'id' => 'jajanan-'.fake()->uuid(),
                        'nama' => 'Siomay 5000',
                        'harga' => 5000,
                        'deskripsi' => 'Paket lengkap isi siomay, telur, tahu putih, kol, pare, dan bumbu kacang. Jika ada yang mau dirubah, tolong isi di catatan ya.',
                        'image' => 'https://i0.wp.com/resepkoki.id/wp-content/uploads/2020/03/Resep-Siomay-Bandung.jpg?fit=1859%2C1920&ssl=1',
                        'kategori' => 'Jajanan Utama'
                    ]);
            
                    $pedagang->jajanan()->create([
                        'id' => 'jajanan-'.fake()->uuid(),
                        'nama' => 'Siomay 3000',
                        'harga' => 3000,
                        'deskripsi' => 'Paket lengkap isi siomay, telur, tahu putih, kol, pare, dan bumbu kacang. Jika ada yang mau dirubah, tolong isi di catatan ya.',
                        'image' => 'https://i0.wp.com/resepkoki.id/wp-content/uploads/2020/03/Resep-Siomay-Bandung.jpg?fit=1859%2C1920&ssl=1',
                        'kategori' => 'Lainnya'
                    ]);
            
                    $pedagang->jajanan()->create([
                        'id' => 'jajanan-'.fake()->uuid(),
                        'nama' => 'Siomay 2000',
                        'harga' => 2000,
                        'deskripsi' => 'Paket lengkap isi siomay, telur, tahu putih, kol, pare, dan bumbu kacang. Jika ada yang mau dirubah, tolong isi di catatan ya.',
                        'image' => 'https://i0.wp.com/resepkoki.id/wp-content/uploads/2020/03/Resep-Siomay-Bandung.jpg?fit=1859%2C1920&ssl=1',
                        'kategori' => 'Lainnya'
                    ]);
                })
        )
        ->create([
            'role' => 'pedagang',
            'latitude' => '-6.984095193876901',
            'longitude' => '110.45416660400392',
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
                    ->afterCreating(function (Pedagang $pedagang) {
                        $pedagang->jajanan()->create([
                            'id' => 'jajanan-'.fake()->uuid(),
                            'nama' => 'Siomay 5000',
                            'harga' => 5000,
                            'deskripsi' => 'Paket lengkap isi siomay, telur, tahu putih, kol, pare, dan bumbu kacang. Jika ada yang mau dirubah, tolong isi di catatan ya.',
                            'image' => 'https://i0.wp.com/resepkoki.id/wp-content/uploads/2020/03/Resep-Siomay-Bandung.jpg?fit=1859%2C1920&ssl=1',
                            'kategori' => 'Jajanan Utama'
                        ]);
                
                        $pedagang->jajanan()->create([
                            'id' => 'jajanan-'.fake()->uuid(),
                            'nama' => 'Siomay 3000',
                            'harga' => 3000,
                            'deskripsi' => 'Paket lengkap isi siomay, telur, tahu putih, kol, pare, dan bumbu kacang. Jika ada yang mau dirubah, tolong isi di catatan ya.',
                            'image' => 'https://i0.wp.com/resepkoki.id/wp-content/uploads/2020/03/Resep-Siomay-Bandung.jpg?fit=1859%2C1920&ssl=1',
                            'kategori' => 'Lainnya'
                        ]);
                
                        $pedagang->jajanan()->create([
                            'id' => 'jajanan-'.fake()->uuid(),
                            'nama' => 'Siomay 2000',
                            'harga' => 2000,
                            'deskripsi' => 'Paket lengkap isi siomay, telur, tahu putih, kol, pare, dan bumbu kacang. Jika ada yang mau dirubah, tolong isi di catatan ya.',
                            'image' => 'https://i0.wp.com/resepkoki.id/wp-content/uploads/2020/03/Resep-Siomay-Bandung.jpg?fit=1859%2C1920&ssl=1',
                            'kategori' => 'Lainnya'
                        ]);
                    })
            )
            ->create([
                'role' => 'pedagang',
                'latitude' => '-6.76644849421157',
                'longitude' => '110.83749700000001',
            ]);

        ZonaTerlarang::create([
            'id' => 'zona-'.fake()->uuid(),
            'latitude' => '-6.752957',
            'longitude' => '110.842589',
            'radius' => 100,
        ]);
    }
}
