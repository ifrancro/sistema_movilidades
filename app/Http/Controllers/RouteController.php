<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $routes = DB::table('routes')
            ->select('routes.*')
            ->selectRaw('(SELECT encrypted_name FROM owners WHERE id = (SELECT owner_id FROM vehicles WHERE route_id = routes.id LIMIT 1)) as owner_name')
            ->get();

        return view('routes.index', compact('routes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('routes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:routes,code',
            'type' => 'required|in:urban,interprovincial,interdepartmental',
            'start_point' => 'required|string|max:255',
            'end_point' => 'required|string|max:255',
            'distance_km' => 'required|numeric|min:0',
            'fare' => 'nullable|numeric|min:0',
            'first_departure' => 'nullable|date_format:H:i',
            'last_departure' => 'nullable|date_format:H:i|after:first_departure',
            'description' => 'nullable|string|max:1000',
        ]);

        $route = DB::table('routes')->insertGetId([
            'name' => $validated['name'],
            'code' => $validated['code'],
            'type' => $validated['type'],
            'start_point' => $validated['start_point'],
            'end_point' => $validated['end_point'],
            'distance_km' => $validated['distance_km'],
            'fare' => $validated['fare'] ?? null,
            'status' => 'active',
            'first_departure' => $validated['first_departure'] ?? null,
            'last_departure' => $validated['last_departure'] ?? null,
            'operating_days' => json_encode(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']),
            'description' => $validated['description'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('routes.index')
            ->with('success', 'Ruta creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $route = DB::table('routes')->find($id);
        $coordinates = DB::table('route_coordinates')
            ->where('route_id', $id)
            ->orderBy('sequence_order')
            ->get();

        return response()->json([
            'route' => $route,
            'coordinates' => $coordinates
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $route = DB::table('routes')->find($id);
        return view('routes.edit', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:routes,code,' . $id,
            'type' => 'required|in:urban,interprovincial,interdepartmental',
            'start_point' => 'required|string|max:255',
            'end_point' => 'required|string|max:255',
            'distance_km' => 'required|numeric|min:0',
            'fare' => 'nullable|numeric|min:0',
            'first_departure' => 'nullable|date_format:H:i',
            'last_departure' => 'nullable|date_format:H:i|after:first_departure',
            'description' => 'nullable|string|max:1000',
        ]);

        DB::table('routes')->where('id', $id)->update([
            'name' => $validated['name'],
            'code' => $validated['code'],
            'type' => $validated['type'],
            'start_point' => $validated['start_point'],
            'end_point' => $validated['end_point'],
            'distance_km' => $validated['distance_km'],
            'fare' => $validated['fare'] ?? null,
            'first_departure' => $validated['first_departure'] ?? null,
            'last_departure' => $validated['last_departure'] ?? null,
            'description' => $validated['description'] ?? null,
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('routes.index')
            ->with('success', 'Ruta actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('routes')->where('id', $id)->delete();
        return redirect()
            ->route('routes.index')
            ->with('success', 'Ruta eliminada exitosamente');
    }
}
