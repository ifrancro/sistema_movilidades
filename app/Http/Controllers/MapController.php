<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{
    /**
     * Show the map interface for route creation
     */
    public function createRoute()
    {
        return view('routes.create');
    }

    /**
     * Get Google Maps Directions API data
     */
    public function getDirections(Request $request)
    {
        $origin = $request->input('origin');
        $destination = $request->input('destination');
        $waypoints = $request->input('waypoints', []);

        // Aquí se integraría con Google Maps Directions API
        // Por ahora retornamos datos de ejemplo
        return response()->json([
            'status' => 'OK',
            'routes' => [
                [
                    'overview_polyline' => [
                        'points' => 'encoded_polyline_string'
                    ],
                    'legs' => [
                        [
                            'distance' => ['text' => '12.5 km', 'value' => 12500],
                            'duration' => ['text' => '45 mins', 'value' => 2700]
                        ]
                    ]
                ]
            ]
        ]);
    }

    /**
     * Snap coordinates to roads using Google Maps Roads API
     */
    public function snapToRoads(Request $request)
    {
        $coordinates = $request->input('coordinates');

        // Aquí se integraría con Google Maps Roads API
        // Por ahora retornamos las coordenadas originales
        return response()->json([
            'snappedPoints' => array_map(function($coord) {
                return [
                    'location' => [
                        'latitude' => $coord['lat'],
                        'longitude' => $coord['lng']
                    ],
                    'originalIndex' => $coord['index'] ?? 0
                ];
            }, $coordinates)
        ]);
    }

    /**
     * Get current vehicle locations for real-time tracking
     */
    public function getVehicleLocations()
    {
        $locations = DB::table('vehicle_locations')
            ->join('vehicles', 'vehicle_locations.vehicle_id', '=', 'vehicles.id')
            ->join('drivers', 'vehicles.driver_id', '=', 'drivers.id')
            ->join('users', 'drivers.user_id', '=', 'users.id')
            ->select(
                'vehicle_locations.*',
                'vehicles.plate_number',
                'vehicles.vehicle_type',
                'users.name as driver_name'
            )
            ->where('vehicle_locations.location_timestamp', '>=', now()->subMinutes(10))
            ->get();

        return response()->json($locations);
    }

    /**
     * Update vehicle location (for GPS tracking)
     */
    public function updateVehicleLocation(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'speed' => 'nullable|numeric',
            'heading' => 'nullable|numeric',
        ]);

        $location = DB::table('vehicle_locations')->insert([
            'vehicle_id' => $request->vehicle_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'speed_kmh' => $request->speed,
            'heading' => $request->heading,
            'location_timestamp' => now(),
            'status' => $request->speed > 5 ? 'moving' : 'stopped',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Verificar si el vehículo se desvió de su ruta
        $this->checkRouteDeviation($request->vehicle_id, $request->latitude, $request->longitude);

        return response()->json(['success' => true]);
    }

    /**
     * Check if vehicle deviated from assigned route
     */
    private function checkRouteDeviation($vehicleId, $latitude, $longitude)
    {
        $vehicle = DB::table('vehicles')
            ->where('id', $vehicleId)
            ->first();

        if (!$vehicle || !$vehicle->route_id) {
            return;
        }

        $routeCoordinates = DB::table('route_coordinates')
            ->where('route_id', $vehicle->route_id)
            ->orderBy('sequence_order')
            ->get();

        $minDistance = PHP_FLOAT_MAX;
        foreach ($routeCoordinates as $coord) {
            $distance = $this->calculateDistance(
                $latitude, $longitude,
                $coord->latitude, $coord->longitude
            );
            $minDistance = min($minDistance, $distance);
        }

        // Si la distancia mínima es mayor a 500 metros, generar alerta
        if ($minDistance > 0.5) {
            $this->createDeviationAlert($vehicleId, $minDistance);
        }
    }

    /**
     * Create deviation alert
     */
    private function createDeviationAlert($vehicleId, $distance)
    {
        DB::table('alerts')->insert([
            'title' => 'Desviación de Ruta Detectada',
            'description' => "El vehículo se desvió {$distance} km de su ruta asignada",
            'type' => 'route_deviation',
            'priority' => 'high',
            'status' => 'pending',
            'vehicle_id' => $vehicleId,
            'created_by' => 1, // Sistema
            'metadata' => json_encode(['deviation_distance' => $distance]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Calculate distance between two points
     */
    private function calculateDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371; // km

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLng/2) * sin($dLng/2);

        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        return $earthRadius * $c;
    }
}
