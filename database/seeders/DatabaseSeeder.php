<?php

namespace Database\Seeders;

use App\Models\Agency;
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
        /* llamar al factory Agency y crear 100 registros */
        \App\Models\Agency::factory()->count(20)->create();
        

    }
}
