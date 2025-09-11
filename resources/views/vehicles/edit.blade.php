@extends('layouts.app')

@section('title', 'Editar Vehículo - Sistema de Gestión de Transporte Público')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="md:flex md:items-center md:justify-between md:space-x-5">
        <div class="flex items-start space-x-5">
            <div class="pt-1.5">
                <h1 class="text-2xl font-bold text-gray-900">Editar Vehículo</h1>
                <p class="text-sm font-medium text-gray-500">Actualiza la información del vehículo</p>
            </div>
        </div>
    </div>

    <div class="mt-8 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <form action="{{ route('vehicles.update', $vehicle) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="space-y-8 divide-y divide-gray-200">
                <div class="space-y-6">
                    <!-- Información básica -->
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Información del Vehículo</h3>
                        <p class="mt-1 text-sm text-gray-500">Modifica los detalles básicos del vehículo.</p>
                    </div>

                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                        <div>
                            <label for="plate_number" class="block text-sm font-medium text-gray-700">Número de Placa</label>
                            <div class="mt-1">
                                <input type="text" name="plate_number" id="plate_number" 
                                    value="{{ $vehicle->plate_number }}"
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('plate_number')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="owner_id" class="block text-sm font-medium text-gray-700">Propietario</label>
                            <div class="mt-1">
                                <select id="owner_id" name="owner_id" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    @foreach($owners as $owner)
                                        <option value="{{ $owner->id }}" {{ $vehicle->owner_id == $owner->id ? 'selected' : '' }}>
                                            {{ decrypt($owner->encrypted_name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('owner_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="brand" class="block text-sm font-medium text-gray-700">Marca</label>
                            <div class="mt-1">
                                <input type="text" name="brand" id="brand" 
                                    value="{{ $vehicle->brand }}"
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('brand')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="model" class="block text-sm font-medium text-gray-700">Modelo</label>
                            <div class="mt-1">
                                <input type="text" name="model" id="model" 
                                    value="{{ $vehicle->model }}"
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('model')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="year" class="block text-sm font-medium text-gray-700">Año</label>
                            <div class="mt-1">
                                <input type="number" name="year" id="year" 
                                    value="{{ $vehicle->year }}"
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('year')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="capacity" class="block text-sm font-medium text-gray-700">Capacidad de Pasajeros</label>
                            <div class="mt-1">
                                <input type="number" name="capacity" id="capacity" 
                                    value="{{ $vehicle->capacity }}"
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('capacity')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="vehicle_type" class="block text-sm font-medium text-gray-700">Tipo de Vehículo</label>
                            <div class="mt-1">
                                <select id="vehicle_type" name="vehicle_type" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="micro" {{ $vehicle->vehicle_type === 'micro' ? 'selected' : '' }}>Micro</option>
                                    <option value="provincial_fleet" {{ $vehicle->vehicle_type === 'provincial_fleet' ? 'selected' : '' }}>Flota Provincial</option>
                                    <option value="departmental_fleet" {{ $vehicle->vehicle_type === 'departmental_fleet' ? 'selected' : '' }}>Flota Departamental</option>
                                </select>
                            </div>
                            @error('vehicle_type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                            <div class="mt-1">
                                <select id="status" name="status" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="active" {{ $vehicle->status === 'active' ? 'selected' : '' }}>Activo</option>
                                    <option value="inactive" {{ $vehicle->status === 'inactive' ? 'selected' : '' }}>Inactivo</option>
                                    <option value="maintenance" {{ $vehicle->status === 'maintenance' ? 'selected' : '' }}>En Mantenimiento</option>
                                </select>
                            </div>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="route_id" class="block text-sm font-medium text-gray-700">Ruta Asignada</label>
                            <div class="mt-1">
                                <select id="route_id" name="route_id" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="">Sin ruta asignada</option>
                                    @foreach($routes as $route)
                                        <option value="{{ $route->id }}" {{ $vehicle->route_id == $route->id ? 'selected' : '' }}>
                                            {{ $route->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('route_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-5">
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('vehicles.index') }}" 
                        class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Guardar Cambios
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
