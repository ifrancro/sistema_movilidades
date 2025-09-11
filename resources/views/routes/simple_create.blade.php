@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Crear Ruta</h3>
        </div>
        <div class="border-t border-gray-200">
            <form action="{{ route('routes.store') }}" method="POST" class="px-4 py-5 sm:p-6">
                @csrf
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label for="start_point" class="block text-sm font-medium text-gray-700">Punto de Inicio</label>
                        <input type="text" name="start_point" id="start_point" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="end_point" class="block text-sm font-medium text-gray-700">Punto Final</label>
                        <input type="text" name="end_point" id="end_point" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <label for="distance" class="block text-sm font-medium text-gray-700">Distancia (km)</label>
                        <input type="number" step="0.01" name="distance" id="distance" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
