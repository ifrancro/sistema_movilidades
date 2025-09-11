@extends('layouts.app')

@section('title', 'Editar Ruta - Sistema de Gestión de Transporte Público')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="md:flex md:items-center md:justify-between md:space-x-5">
        <div class="flex items-start space-x-5">
            <div class="pt-1.5">
                <h1 class="text-2xl font-bold text-gray-900">Editar Ruta</h1>
                <p class="text-sm font-medium text-gray-500">Modifica los detalles de la ruta</p>
            </div>
        </div>
    </div>

    <div class="mt-8">
        <form action="{{ route('routes.update', $route->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Información de la Ruta</h3>
                    <p class="mt-1 text-sm text-gray-500">Actualiza los detalles básicos de la ruta.</p>
                </div>

                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nombre de la Ruta</label>
                        <div class="mt-1">
                            <input type="text" name="name" id="name" required
                                value="{{ old('name', $route->name) }}"
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700">Código de Ruta</label>
                        <div class="mt-1">
                            <input type="text" name="code" id="code" required
                                value="{{ old('code', $route->code) }}"
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                        @error('code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Tipo de Ruta</label>
                        <div class="mt-1">
                            <select id="type" name="type" required
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                <option value="urban" {{ $route->type === 'urban' ? 'selected' : '' }}>Urbana</option>
                                <option value="interprovincial" {{ $route->type === 'interprovincial' ? 'selected' : '' }}>Interprovincial</option>
                                <option value="interdepartmental" {{ $route->type === 'interdepartmental' ? 'selected' : '' }}>Interdepartamental</option>
                            </select>
                        </div>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="distance_km" class="block text-sm font-medium text-gray-700">Distancia (km)</label>
                        <div class="mt-1">
                            <input type="number" step="0.1" name="distance_km" id="distance_km" required
                                value="{{ old('distance_km', $route->distance_km) }}"
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                        @error('distance_km')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="start_point" class="block text-sm font-medium text-gray-700">Punto de Inicio</label>
                        <div class="mt-1">
                            <input type="text" name="start_point" id="start_point" required
                                value="{{ old('start_point', $route->start_point) }}"
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                        @error('start_point')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="end_point" class="block text-sm font-medium text-gray-700">Punto Final</label>
                        <div class="mt-1">
                            <input type="text" name="end_point" id="end_point" required
                                value="{{ old('end_point', $route->end_point) }}"
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                        @error('end_point')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="first_departure" class="block text-sm font-medium text-gray-700">Primera Salida</label>
                        <div class="mt-1">
                            <input type="time" name="first_departure" id="first_departure"
                                value="{{ old('first_departure', $route->first_departure) }}"
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                        @error('first_departure')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="last_departure" class="block text-sm font-medium text-gray-700">Última Salida</label>
                        <div class="mt-1">
                            <input type="time" name="last_departure" id="last_departure"
                                value="{{ old('last_departure', $route->last_departure) }}"
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                        @error('last_departure')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="fare" class="block text-sm font-medium text-gray-700">Tarifa (Bs.)</label>
                        <div class="mt-1">
                            <input type="number" step="0.5" name="fare" id="fare"
                                value="{{ old('fare', $route->fare) }}"
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                        @error('fare')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                        <div class="mt-1">
                            <textarea name="description" id="description" rows="3"
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('description', $route->description) }}</textarea>
                        </div>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="pt-5">
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('routes.index') }}" 
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
