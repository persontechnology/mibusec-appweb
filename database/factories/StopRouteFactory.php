<?php

namespace Database\Factories;

use App\Models\Route;
use App\Models\Stop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StopRoute>
 */
class StopRouteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'stop_id' => Stop::factory(),   // crea una parada si no existe
            'route_id' => Route::factory(), // crea una ruta si no existe
            'sort_order' => $this->faker->numberBetween(1, 20),
            'arrival_time' => $this->faker->optional()->time('H:i'),
            'departure_time' => $this->faker->optional()->time('H:i'),
            'notes' => $this->faker->optional()->sentence,
            'status' => $this->faker->randomElement(['START', 'PROCESS', 'END']),
        ];
    }
}
