@extends('home.admin')

@section('title', 'Residents Location Map')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div class="p-6">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-900">Residents Location Map</h2>
            <p class="text-gray-600 mt-1">View resident addresses and geo-tagged locations</p>
        </div>
        
        <div class="p-6">
            <!-- Map Container -->
            <div id="residentsMap" class="w-full h-96 bg-gray-200 rounded-xl mb-6"></div>
            
            <!-- Residents List -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @forelse($residents as $resident)
                <div class="bg-gray-50 rounded-xl p-4 hover:bg-gray-100 transition-colors cursor-pointer" 
                     onclick="focusOnResident({{ $resident->latitude }}, {{ $resident->longitude }}, '{{ $resident->name }}')">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-medium text-gray-900">{{ $resident->name }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ $resident->purok }}</p>
                            <p class="text-sm text-gray-500 mt-2">{{ $resident->full_address ?? 'No address provided' }}</p>
                        </div>
                        <div class="text-right text-xs text-gray-400">
                            <p>{{ $resident->latitude }}, {{ $resident->longitude }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-2 text-center py-12">
                    <i data-feather="map-pin" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Geo-tagged Residents</h3>
                    <p class="text-gray-500">Residents with location data will appear here</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
    let map, markers = [];
    
    function initResidentsMap() {
        const dumaguete = [9.3077, 123.3026];
        
        map = L.map('residentsMap').setView(dumaguete, 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        
        // Add markers for each resident
        const residents = @json($residents);
        
        residents.forEach(resident => {
            if (resident.latitude && resident.longitude) {
                const marker = L.marker([parseFloat(resident.latitude), parseFloat(resident.longitude)])
                    .addTo(map)
                    .bindPopup(`
                        <div class="p-2">
                            <h3 class="font-medium text-gray-900">${resident.name}</h3>
                            <p class="text-sm text-gray-600">${resident.purok}</p>
                            <p class="text-sm text-gray-500 mt-1">${resident.full_address || 'No address provided'}</p>
                            <p class="text-xs text-gray-400 mt-2">Coordinates: ${resident.latitude}, ${resident.longitude}</p>
                        </div>
                    `);
                
                markers.push({ marker, resident });
            }
        });
        
        // Adjust map bounds to show all markers
        if (markers.length > 0) {
            const group = new L.featureGroup(markers.map(m => m.marker));
            map.fitBounds(group.getBounds().pad(0.1));
        }
    }
    
    function focusOnResident(lat, lng, name) {
        map.setView([parseFloat(lat), parseFloat(lng)], 16);
        
        // Find and open the corresponding popup
        const marker = markers.find(m => 
            Math.abs(m.marker.getLatLng().lat - parseFloat(lat)) < 0.0001 && 
            Math.abs(m.marker.getLatLng().lng - parseFloat(lng)) < 0.0001
        );
        
        if (marker) {
            marker.marker.openPopup();
        }
    }
    
    // Initialize map when page loads
    document.addEventListener('DOMContentLoaded', function() {
        initResidentsMap();
    });
    
    feather.replace();
</script>
@endsection