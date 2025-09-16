<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Owner;
use App\Models\Route;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with('owner')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $owners = Owner::where('status', 'active')->get();
        $routes = Route::where('status', 'active')->get();
        return view('vehicles.create', compact('owners', 'routes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plate_number' => 'required|string|max:10|unique:vehicles,plate_number',
            'chassis_number' => 'required|string|max:50|unique:vehicles,chassis_number',
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'year' => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'color' => 'required|string|max:50',
            'capacity' => 'required|integer|min:1',
            'vehicle_type' => 'required|string|in:micro,provincial_fleet,departmental_fleet',
            'owner_id' => 'required|exists:owners,id',
            'route_id' => 'required|exists:routes,id',
            'status' => 'required|string|in:active,maintenance,decommissioned',
            'registration_date' => 'required|date',
            'insurance_expiry' => 'nullable|date',
            'technical_inspection_expiry' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        try {
            $vehicle = Vehicle::create($validated);
            return redirect()
                ->route('vehicles.index')
                ->with('success', 'Vehículo registrado exitosamente');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al registrar el vehículo: ' . $e->getMessage());
        }

        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Vehículo registrado exitosamente');
    }

    public function show(Vehicle $vehicle)
    {
        return view('vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        $owners = Owner::all();
        $routes = Route::all();
        return view('vehicles.edit', compact('vehicle', 'owners', 'routes'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'plate_number' => 'required|string|max:10|unique:vehicles,plate_number,' . $vehicle->id,
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'year' => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'capacity' => 'required|integer|min:1',
            'vehicle_type' => 'required|string|in:micro,provincial_fleet,departmental_fleet',
            'owner_id' => 'required|exists:owners,id',
            'route_id' => 'nullable|exists:routes,id',
            'status' => 'required|string|in:active,inactive,maintenance',
        ]);

        // Actualizar el vehículo
        $vehicle->update($validated);

        // Redirigir al index con mensaje de éxito
        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Vehículo actualizado exitosamente');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()
            ->route('vehicles.index')
            ->with('success', 'Vehículo eliminado exitosamente');
    }
}
