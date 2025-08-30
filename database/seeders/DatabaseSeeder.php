<?php

namespace Database\Seeders;

use App\Models\Route;
use App\Models\RouteDistance;
use App\Models\Stop;
use App\Models\StopRoute;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleRoute;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       $this->call(PermissionRoleUserSeed::class);
        $stops= Stop::factory(100)->create();
        $vehicles = Vehicle::factory(100)->create();
        $routes = Route::factory(200)->create();

        // Generamos relaciones entre stops y routes
        $routes->each(function ($route) use ($stops) {
            $stops->random(rand(5, 10))->each(function ($stop, $index) use ($route) {
                StopRoute::factory()->create([
                    'stop_id' => $stop->id,
                    'route_id' => $route->id,
                    'sort_order' => $index + 1,
                ]);
            });
        });


        // Cada ruta tendrá entre 1 y 3 vehículos asignados
        $routes->each(function ($route) use ($vehicles) {
            $vehicles->random(rand(1, 3))->each(function ($vehicle) use ($route) {
                VehicleRoute::factory()->create([
                    'vehicle_id' => $vehicle->id,
                    'route_id' => $route->id,
                    'assigned_date' => now()->subDays(rand(0, 30)),
                ]);
            });
        });

        // para crear route distancia  
        $routes->each(function ($route) {
        $orderedStops = StopRoute::query()
            ->where('route_id', $route->id)
            ->orderBy('sort_order')
            ->pluck('stop_id')
            ->values();

        // Crear distancias para pares consecutivos: (s0->s1), (s1->s2), ...
        for ($i = 0; $i < $orderedStops->count() - 1; $i++) {
            RouteDistance::factory()->create([
                'route_id'     => $route->id,
                'from_stop_id' => $orderedStops[$i],
                'to_stop_id'   => $orderedStops[$i + 1],
                'distance_km'  => fake()->randomFloat(1, 0.5, 80),
                'estimated_time' => sprintf('%02d:%02d:00', fake()->numberBetween(0, 3), fake()->randomElement([5,10,15,20,25,30,35,40,45,50,55])),
            ]);
        }
    });
    }
}
