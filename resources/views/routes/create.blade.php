@extends('layouts.app')

@section('title', 'Crear Ruta - Sistema de Gestión de Transporte Público')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="md:flex md:items-center md:justify-between md:space-x-5">
        <div class="flex items-start space-x-5">
            <div class="pt-1.5">
                <h1 class="text-2xl font-bold text-gray-900">Crear Nueva Ruta</h1>
                <p class="text-sm font-medium text-gray-500">Dibuja la ruta en el mapa y completa los detalles.</p>
            </div>
        </div>
    </div>

    <div class="mt-8">
        <form action="{{ route('routes.store') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Información de la Ruta -->
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Información de la Ruta</h3>
                    <p class="mt-1 text-sm text-gray-500">Completa los detalles básicos de la ruta.</p>
                </div>

                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nombre de la Ruta</label>
                        <input type="text" name="name" id="name" required
                            class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700">Código de Ruta</label>
                        <input type="text" name="code" id="code" required
                            class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Tipo de Ruta</label>
                        <select id="type" name="type" required
                            class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            <option value="urban">Urbana</option>
                            <option value="interprovincial">Interprovincial</option>
                            <option value="interdepartmental">Interdepartamental</option>
                        </select>
                    </div>

                    <div>
                        <label for="distance_km" class="block text-sm font-medium text-gray-700">Distancia (km)</label>
                        <input type="number" step="0.1" name="distance_km" id="distance_km" required
                            class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>
            </div>

            <!-- Mapa de la Ruta -->
            <div class="mt-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Mapa de la Ruta</h3>
                <p class="mt-1 text-sm text-gray-500">Haz clic en el mapa para dibujar la ruta.</p>
                <div id="map" class="mt-4" style="height: 400px; border: 1px solid #ccc;"></div>
                <input type="hidden" name="coordinates" id="coordinates" value="{{ old('coordinates', '[]') }}">
            </div>

            <!-- Botones -->
            <div class="pt-5">
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('routes.index') }}" 
                        class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Guardar Ruta
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Leaflet.js -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-oPq+bJN2+H6p6Y9e1u1qz+v+0z+QeFG9v9pc5d2r5rM=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-oPq+bJN2+H6p6Y9e1u1qz+v+0z+QeFG9v9pc5d2r5rM=" crossorigin=""></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inicializar mapa centrado en Santa Cruz, Bolivia
        const map = L.map('map').setView([-17.7833, -63.1821], 13);

        // Capa base
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Recuperar coordenadas guardadas
        let drawnCoordinates = JSON.parse(document.getElementById('coordinates').value || '[]');
        let polyline = L.polyline([], { color: 'blue' }).addTo(map);

        // Si ya hay coordenadas, dibujar y ajustar vista
        if (drawnCoordinates.length > 0) {
            polyline.setLatLngs(drawnCoordinates);
            map.fitBounds(polyline.getBounds());
        }

        // Evento click para agregar puntos
        map.on('click', function (e) {
            const { lat, lng } = e.latlng;
            drawnCoordinates.push([lat, lng]);
            polyline.setLatLngs(drawnCoordinates);
            document.getElementById('coordinates').value = JSON.stringify(drawnCoordinates);
        });
    });
</script>
@endsection
