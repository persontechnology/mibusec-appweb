<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VehicleController extends Controller
{
    public function getDeviceEcuatrackApi()
    {
        $url_web_gps = "https://www.ecuatracker.com/";
        $token = '$2y$10$ADoMYuqsZXW9sVZLLTYgHu3faZCv6SxoAC.0vnTr8TLB3upfGetqC';

        try {
            $responseApi = Http::get($url_web_gps . 'api/get_devices', [
                'user_api_hash' => $token,
                'lang' => 'es'
            ]);

            if ($responseApi->failed()) {
                return response()->json(['error' => 'Error al obtener datos de la API.'], 502);
            }

            $items = data_get($responseApi->json(), '0.items', []);

            $result = collect($items)->map(function ($item) {
                $data = [
                    'codigo'    => data_get($item, 'device_data.traccar.uniqueId'),
                    'name'      => data_get($item, 'device_data.traccar.name'),
                    'latitud'   => data_get($item, 'device_data.traccar.lastValidLatitude'),
                    'longitud'  => data_get($item, 'device_data.traccar.lastValidLongitude'),
                    'velocidad' => floatval(data_get($item, 'device_data.traccar.speed', 0)),
                ];

                // Crear o actualizar el vehículo según el código
                Vehicle::updateOrCreate(
                    ['codigo' => $data['codigo']],
                    $data
                );

                return $data;
            })->filter();

            return response()->json($result->values());
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Excepción: ' . $e->getMessage()], 500);
        }
    }
}
