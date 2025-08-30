<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'license_plate' => strtoupper($this->faker->bothify('???-####')),
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'capacity' => $this->faker->numberBetween(2, 60), // por ejemplo, asientos
            'status' => $this->faker->randomElement(['ACTIVE', 'ANACTIVE']),
            'notes' => $this->faker->optional()->sentence,
        ];
    }
}
