@extends('layouts.app')

@section('title', 'Editar Propietario - Sistema de Gestión de Transporte Público')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="md:flex md:items-center md:justify-between md:space-x-5">
        <div class="flex items-start space-x-5">
            <div class="pt-1.5">
                <h1 class="text-2xl font-bold text-gray-900">Editar Propietario</h1>
                <p class="text-sm font-medium text-gray-500">Actualiza la información del propietario</p>
            </div>
        </div>
    </div>

    <div class="mt-8 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <form action="{{ route('owners.update', $owner) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="space-y-8 divide-y divide-gray-200">
                <div class="space-y-6">
                    <!-- Información básica -->
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Información del Propietario</h3>
                        <p class="mt-1 text-sm text-gray-500">Modifica los detalles del propietario.</p>
                    </div>

                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                            <div class="mt-1">
                                <input type="text" name="name" id="name" 
                                    value="{{ decrypt($owner->encrypted_name) }}"
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="ci_nit" class="block text-sm font-medium text-gray-700">CI/NIT</label>
                            <div class="mt-1">
                                <input type="text" name="ci_nit" id="ci_nit" 
                                    value="{{ decrypt($owner->encrypted_ci_nit) }}"
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('ci_nit')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Dirección</label>
                            <div class="mt-1">
                                <input type="text" name="address" id="address" 
                                    value="{{ decrypt($owner->encrypted_address) }}"
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('address')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Teléfono</label>
                            <div class="mt-1">
                                <input type="tel" name="phone" id="phone" 
                                    value="{{ decrypt($owner->encrypted_phone) }}"
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            @error('phone')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="owner_type" class="block text-sm font-medium text-gray-700">Tipo de Propietario</label>
                            <div class="mt-1">
                                <select id="owner_type" name="owner_type" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="individual" {{ $owner->owner_type === 'individual' ? 'selected' : '' }}>Individual</option>
                                    <option value="company" {{ $owner->owner_type === 'company' ? 'selected' : '' }}>Empresa</option>
                                    <option value="association" {{ $owner->owner_type === 'association' ? 'selected' : '' }}>Asociación</option>
                                    <option value="cooperative" {{ $owner->owner_type === 'cooperative' ? 'selected' : '' }}>Cooperativa</option>
                                </select>
                            </div>
                            @error('owner_type')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                            <div class="mt-1">
                                <select id="status" name="status" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="active" {{ $owner->status === 'active' ? 'selected' : '' }}>Activo</option>
                                    <option value="inactive" {{ $owner->status === 'inactive' ? 'selected' : '' }}>Inactivo</option>
                                    <option value="suspended" {{ $owner->status === 'suspended' ? 'selected' : '' }}>Suspendido</option>
                                </select>
                            </div>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notas</label>
                            <div class="mt-1">
                                <textarea id="notes" name="notes" rows="4" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ $owner->notes }}</textarea>
                            </div>
                            @error('notes')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-5">
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('owners.index') }}" 
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
