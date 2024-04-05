<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pedagang>
 */
class PedagangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => 'pedagang-'.fake()->uuid(),
            'status' => 'buka',
            'jam_buka' => '08:00',
            'jam_tutup' => '17:00',
            'daerah_dagang' => 'Kudus',
            'average_rating' => fake()->randomFloat(1, 4.0, 5.0),
            'sertifikasi_halal' => fake()->numberBetween(0, 1),
        ];
    }
}
