<?php

namespace Database\Factories;

use App\Models\Route;
use App\Models\Stop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RouteDistance>
 */
class RouteDistanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'from_stop_id'  => Stop::factory(),
            'to_stop_id'    => Stop::factory(),
            'route_id'      => Route::factory(),
            'distance_km'   => $this->faker->randomFloat(1, 0.5, 80), // 0.5–80 km
            'estimated_time'=> $this->faker->optional()->time('H:i:s'),
        ];
    }

      /**
     * Estado para asegurar que from != to cuando se creen usando IDs existentes.
     */
    public function distinctStops(): static
    {
        return $this->state(function (array $attrs) {
            if (($attrs['from_stop_id'] ?? null) === ($attrs['to_stop_id'] ?? null)) {
                $attrs['to_stop_id'] = Stop::factory();
            }
            return $attrs;
        });
    }
}
