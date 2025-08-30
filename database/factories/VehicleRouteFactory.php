<?php

namespace Database\Factories;

use App\Models\Route;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VehicleRoute>
 */
class VehicleRouteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vehicle_id' => Vehicle::factory(),   // crea un vehículo si no existe
            'route_id' => Route::factory(),       // crea una ruta si no existe
            'assigned_date' => $this->faker->optional()->date(),
            'status' => $this->faker->randomElement(['ASSIGNED', 'IN_PROGRESS', 'COMPLETED']),
            'notes' => $this->faker->optional()->sentence,
        ];
    }
}
