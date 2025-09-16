@extends('layouts.app')

@section('title', 'Crear Ruta - Sistema de Gestión de Transporte Público')

@push('styles')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
  <link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css"/>
  <style>
    .map-container{ position:relative; height:500px; border:2px solid #e5e7eb; border-radius:8px; overflow:hidden; }
    #map{ height:100%; width:100%; background:#f3f4f6; }
    /* Evita artefactos de mosaicos al escalar en algunos navegadores */
    .leaflet-pane, .leaflet-map-pane, .leaflet-tile, .leaflet-tile-container{
      -webkit-transform: translateZ(0);
              transform: translateZ(0);
    }
  </style>
@endpush

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
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                   class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
            @error('name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
          </div>

          <div>
            <label for="code" class="block text-sm font-medium text-gray-700">Código de Ruta</label>
            <input type="text" name="code" id="code" value="{{ old('code') }}" required
                   class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
            @error('code')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
          </div>

          <div>
            <label for="type" class="block text-sm font-medium text-gray-700">Tipo de Ruta</label>
            <select id="type" name="type" required
                    class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
              <option value="urban" {{ old('type')==='urban'?'selected':'' }}>Urbana</option>
              <option value="interprovincial" {{ old('type')==='interprovincial'?'selected':'' }}>Interprovincial</option>
              <option value="interdepartmental" {{ old('type')==='interdepartmental'?'selected':'' }}>Interdepartamental</option>
            </select>
            @error('type')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
          </div>

          <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
            <select id="status" name="status" required
                    class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
              <option value="active" {{ old('status')==='active'?'selected':'' }}>Activa</option>
              <option value="inactive" {{ old('status')==='inactive'?'selected':'' }}>Inactiva</option>
            </select>
            @error('status')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
          </div>

          <div>
            <label for="start_point" class="block text-sm font-medium text-gray-700">Punto de Inicio</label>
            <input type="text" name="start_point" id="start_point" value="{{ old('start_point') }}"
                   class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
            @error('start_point')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
          </div>

          <div>
            <label for="end_point" class="block text-sm font-medium text-gray-700">Punto Final</label>
            <input type="text" name="end_point" id="end_point" value="{{ old('end_point') }}"
                   class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
            @error('end_point')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
          </div>

          <div>
            <label for="fare" class="block text-sm font-medium text-gray-700">Tarifa (Bs)</label>
            <input type="number" name="fare" id="fare" step="0.01" value="{{ old('fare') }}"
                   class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
            @error('fare')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
          </div>

          <div>
            <label for="estimated_duration_minutes" class="block text-sm font-medium text-gray-700">Duración Estimada (min)</label>
            <input type="number" name="estimated_duration_minutes" id="estimated_duration_minutes" step="1" value="{{ old('estimated_duration_minutes') }}"
                   class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
            @error('estimated_duration_minutes')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
          </div>

          <div>
            <label for="first_departure" class="block text-sm font-medium text-gray-700">Primer Salida</label>
            <input type="time" name="first_departure" id="first_departure" value="{{ old('first_departure') }}"
                   class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
            @error('first_departure')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
          </div>

          <div>
            <label for="last_departure" class="block text-sm font-medium text-gray-700">Última Salida</label>
            <input type="time" name="last_departure" id="last_departure" value="{{ old('last_departure') }}"
                   class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
            @error('last_departure')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
          </div>

          <div>
            <label for="distance_km" class="block text-sm font-medium text-gray-700">Distancia (km)</label>
            <input type="number" step="0.01" name="distance_km" id="distance_km"
                   value="{{ old('distance_km') }}" readonly
                   class="mt-1 bg-gray-50 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
            @error('distance_km')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Días de Operación</label>
          @php
            $days = ['monday'=>'Lunes','tuesday'=>'Martes','wednesday'=>'Miércoles','thursday'=>'Jueves','friday'=>'Viernes','saturday'=>'Sábado','sunday'=>'Domingo'];
            $oldDays = old('operating_days', []);
          @endphp
          <div class="mt-2 grid grid-cols-2 sm:grid-cols-4 gap-2">
            @foreach($days as $key=>$label)
              <label class="inline-flex items-center">
                <input type="checkbox" name="operating_days[]" value="{{ $key }}"
                       {{ in_array($key, $oldDays) ? 'checked' : '' }}
                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">{{ $label }}</span>
              </label>
            @endforeach
          </div>
          @error('operating_days')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
          <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
          <textarea id="description" name="description" rows="3"
                    class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ old('description') }}</textarea>
          @error('description')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
      </div>

      <!-- Mapa de la Ruta -->
      <div class="mt-6 space-y-4">
        <div>
          <h3 class="text-lg leading-6 font-medium text-gray-900">Mapa de la Ruta</h3>
          <p class="mt-1 text-sm text-gray-500">Usa el botón de polilínea o haz clic en el mapa para agregar puntos. Puedes editar/arrastrar y eliminar la ruta.</p>
        </div>

        <div class="map-container">
          <div id="map"></div>
        </div>

        <!-- Coordenadas [[lat,lng], ...] -->
        <input type="hidden" name="coordinates" id="coordinates" value='{{ old('coordinates', "[]") }}'>
      </div>

      <!-- Botones -->
      <div class="pt-5">
        <div class="flex justify-end space-x-3">
          <a href="{{ route('routes.index') }}"
             class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
             Cancelar
          </a>
          <button type="submit"
                  class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
            Guardar Ruta
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>
  <script>
    let map, drawnItems, startMarker = null, endMarker = null;

    function initMap() {
      // Evita doble init
      if (map) { map.remove(); map = null; }

      map = L.map('map', {
        center: [-17.7833, -63.1821], // Santa Cruz
        zoom: 13,
        zoomControl: true,
        scrollWheelZoom: true,
      });

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
      }).addTo(map);

      // Grupo editable para Leaflet.draw
      drawnItems = new L.FeatureGroup().addTo(map);

      const drawControl = new L.Control.Draw({
        draw: {
          polyline: { shapeOptions: { color: '#3b82f6', weight: 4, opacity: 0.9 } },
          polygon: false, circle: false, rectangle: false, marker: false, circlemarker: false
        },
        edit: { featureGroup: drawnItems, remove: true }
      });
      map.addControl(drawControl);

      // Cargar coordenadas guardadas (old() o modo edición)
      const hidden = document.getElementById('coordinates');
      let coords = [];
      try { coords = JSON.parse(hidden.value || '[]'); } catch (_) { coords = []; }

      if (isGeoJsonLineString(coords)) {
        // Si te llega GeoJSON LineString, conviértelo a [[lat,lng],...]
        coords = coords.coordinates.map(([lng,lat]) => [lat,lng]);
      }

      if (Array.isArray(coords) && coords.length) {
        const poly = L.polyline(coords, { color:'#3b82f6', weight:4, opacity:0.9 });
        drawnItems.addLayer(poly);
        refreshStateFromPolyline(poly);
        map.fitBounds(poly.getBounds(), { padding: [20,20] });
      }

      // Eventos de Leaflet.draw
      map.on(L.Draw.Event.CREATED, (e) => {
        if (e.layerType === 'polyline') {
          drawnItems.clearLayers(); // mantener una sola ruta
          drawnItems.addLayer(e.layer);
          refreshStateFromPolyline(e.layer);
        }
      });

      map.on(L.Draw.Event.EDITED, (e) => {
        e.layers.eachLayer(layer => refreshStateFromPolyline(layer));
      });

      map.on(L.Draw.Event.DELETED, () => {
        setHiddenCoords([]);
        clearEndpoints();
        const d = document.getElementById('distance_km');
        if (d) d.value = '';
      });

      // Click para agregar puntos sin usar la toolbar
      map.on('click', (e) => {
        let poly = getPolyline();
        if (!poly) {
          poly = L.polyline([e.latlng], { color:'#3b82f6', weight:4, opacity:0.9 });
          drawnItems.addLayer(poly);
          refreshStateFromPolyline(poly);
        } else {
          const latlngs = poly.getLatLngs();
          latlngs.push(e.latlng);
          poly.setLatLngs(latlngs);
          refreshStateFromPolyline(poly);
        }
      });

      // Arreglos típicos de “mapa corrupto” por tamaño/visibilidad
      map.whenReady(() => { setTimeout(() => map.invalidateSize(), 0); });
      const container = document.querySelector('.map-container') || document.getElementById('map');
      if (container && 'ResizeObserver' in window) {
        const ro = new ResizeObserver(() => map && map.invalidateSize());
        ro.observe(container);
      }
    }

    function getPolyline() {
      let found = null;
      drawnItems.eachLayer(l => { if (l instanceof L.Polyline) found = l; });
      return found;
    }

    function refreshStateFromPolyline(poly) {
      const latlngs = poly.getLatLngs().map(ll => [ll.lat, ll.lng]);
      setHiddenCoords(latlngs);
      drawEndpoints(latlngs);
      updateDistance(latlngs);
    }

    function setHiddenCoords(arr) {
      document.getElementById('coordinates').value = JSON.stringify(arr);
    }

    function updateDistance(coords) {
      const input = document.getElementById('distance_km');
      if (!input) return;
      if (coords.length < 2) { input.value = ''; return; }
      let dist = 0;
      for (let i=1; i<coords.length; i++) {
        dist += L.latLng(coords[i-1]).distanceTo(L.latLng(coords[i]));
      }
      input.value = (dist/1000).toFixed(2);
    }

    function clearEndpoints() {
      if (startMarker) { map.removeLayer(startMarker); startMarker = null; }
      if (endMarker)   { map.removeLayer(endMarker);   endMarker = null; }
    }

    function drawEndpoints(coords) {
      clearEndpoints();
      if (!coords.length) return;
      const start = L.latLng(coords[0]);
      startMarker = L.circleMarker(start, { radius:6, color:'#10b981', fillColor:'#10b981', fillOpacity:1 }).addTo(map);
      if (coords.length > 1) {
        const end = L.latLng(coords[coords.length-1]);
        endMarker = L.circleMarker(end, { radius:6, color:'#ef4444', fillColor:'#ef4444', fillOpacity:1 }).addTo(map);
      }
    }

    function isGeoJsonLineString(obj) {
      return obj && obj.type === 'LineString' && Array.isArray(obj.coordinates);
    }

    document.addEventListener('DOMContentLoaded', initMap);
  </script>
@endpush
