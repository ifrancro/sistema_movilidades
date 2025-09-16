<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function index()
    {
        $owners = Owner::with('vehicles')->paginate(10);
        return view('owners.index', compact('owners'));
    }

    public function create()
    {
        return view('owners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'ci_nit' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'owner_type' => 'required|in:individual,company,association,cooperative',
            'status' => 'required|in:active,inactive,suspended',
            'registration_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $owner = new Owner();
        $owner->user_id = auth()->id(); // Asignar el ID del usuario autenticado
        $owner->encrypted_name = encrypt($validated['name']);
        $owner->encrypted_ci_nit = encrypt($validated['ci_nit']);
        $owner->encrypted_address = encrypt($validated['address']);
        $owner->encrypted_phone = encrypt($validated['phone']);
        $owner->owner_type = $validated['owner_type'];
        $owner->status = $validated['status'];
        $owner->registration_date = $validated['registration_date'];
        $owner->notes = $validated['notes'];
        $owner->save();

        return redirect()->route('owners.index')->with('success', 'Propietario registrado exitosamente.');
    }

    public function show(Owner $owner)
    {
        return view('owners.show', compact('owner'));
    }

    public function edit(Owner $owner)
    {
        return view('owners.edit', compact('owner'));
    }

    public function update(Request $request, Owner $owner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'ci_nit' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'owner_type' => 'required|in:individual,company,association,cooperative',
            'status' => 'required|in:active,inactive,suspended',
            'notes' => 'nullable|string',
        ]);

        $owner->encrypted_name = encrypt($validated['name']);
        $owner->encrypted_ci_nit = encrypt($validated['ci_nit']);
        $owner->encrypted_address = encrypt($validated['address']);
        $owner->encrypted_phone = encrypt($validated['phone']);
        $owner->owner_type = $validated['owner_type'];
        $owner->status = $validated['status'];
        $owner->notes = $validated['notes'];
        $owner->save();

        return redirect()->route('owners.index')->with('success', 'Propietario actualizado exitosamente.');
    }

    public function destroy(Owner $owner)
    {
        // Verificar si tiene vehículos asociados
        if ($owner->vehicles()->count() > 0) {
            return back()->with('error', 'No se puede eliminar el propietario porque tiene vehículos asociados.');
        }

        $owner->delete();
        return redirect()->route('owners.index')->with('success', 'Propietario eliminado exitosamente.');
    }
}
