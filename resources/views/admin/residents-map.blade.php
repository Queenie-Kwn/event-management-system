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
            <!-- Filter Section -->
            <div class="mb-4">
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Filter by Cash Assistance Program</h3>
                <div class="flex flex-wrap gap-2 mb-4">
                    <button onclick="filterByProgram('all')" class="filter-btn px-4 py-2 rounded-lg font-medium transition-all bg-gray-600 text-white" data-program="all">
                        All Programs
                    </button>
                    <button onclick="filterByProgram('Pantawid Pamilyang Pilipino Program (4Ps)')" class="filter-btn px-4 py-2 rounded-lg font-medium transition-all bg-gray-200 text-gray-700 hover:bg-red-500 hover:text-white" data-program="Pantawid Pamilyang Pilipino Program (4Ps)">
                        <span class="inline-block w-3 h-3 rounded-full bg-red-500 mr-2"></span>Pantawid (4Ps)
                    </button>
                    <button onclick="filterByProgram('Targeted Cash Transfers (TCT)')" class="filter-btn px-4 py-2 rounded-lg font-medium transition-all bg-gray-200 text-gray-700 hover:bg-blue-500 hover:text-white" data-program="Targeted Cash Transfers (TCT)">
                        <span class="inline-block w-3 h-3 rounded-full bg-blue-500 mr-2"></span>TCT
                    </button>
                    <button onclick="filterByProgram('Sustainable Livelihood Program (SLP)')" class="filter-btn px-4 py-2 rounded-lg font-medium transition-all bg-gray-200 text-gray-700 hover:bg-orange-500 hover:text-white" data-program="Sustainable Livelihood Program (SLP)">
                        <span class="inline-block w-3 h-3 rounded-full bg-orange-500 mr-2"></span>SLP
                    </button>
                    <button onclick="filterByProgram('Assistance to Individuals in Crisis Situations (AICS)')" class="filter-btn px-4 py-2 rounded-lg font-medium transition-all bg-gray-200 text-gray-700 hover:bg-yellow-500 hover:text-white" data-program="Assistance to Individuals in Crisis Situations (AICS)">
                        <span class="inline-block w-3 h-3 rounded-full bg-yellow-500 mr-2"></span>AICS
                    </button>
                </div>
                
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Filter by Purok</h3>
                <div class="flex flex-wrap gap-2">
                    <button onclick="filterByPurok('all')" class="purok-btn px-4 py-2 rounded-lg font-medium transition-all bg-indigo-600 text-white" data-purok="all">
                        All Puroks
                    </button>
                    <button onclick="filterByPurok('Purok Mahigugma-on')" class="purok-btn px-4 py-2 rounded-lg font-medium transition-all bg-gray-200 text-gray-700 hover:bg-indigo-500 hover:text-white" data-purok="Purok Mahigugma-on">
                        Mahigugma-on
                    </button>
                    <button onclick="filterByPurok('Purok Gumamela')" class="purok-btn px-4 py-2 rounded-lg font-medium transition-all bg-gray-200 text-gray-700 hover:bg-indigo-500 hover:text-white" data-purok="Purok Gumamela">
                        Gumamela
                    </button>
                    <button onclick="filterByPurok('Purok Santol')" class="purok-btn px-4 py-2 rounded-lg font-medium transition-all bg-gray-200 text-gray-700 hover:bg-indigo-500 hover:text-white" data-purok="Purok Santol">
                        Santol
                    </button>
                    <button onclick="filterByPurok('Purok Cebasca')" class="purok-btn px-4 py-2 rounded-lg font-medium transition-all bg-gray-200 text-gray-700 hover:bg-indigo-500 hover:text-white" data-purok="Purok Cebasca">
                        Cebasca
                    </button>
                    <button onclick="filterByPurok('Purok Fuente')" class="purok-btn px-4 py-2 rounded-lg font-medium transition-all bg-gray-200 text-gray-700 hover:bg-indigo-500 hover:text-white" data-purok="Purok Fuente">
                        Fuente
                    </button>
                </div>
            </div>
            
            <!-- Map Container -->
            <div id="residentsMap" class="w-full h-96 bg-gray-200 rounded-xl mb-6 relative z-0"></div>
            
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
            
            <!-- Pagination -->
            @if($residents->hasPages())
            <div class="mt-6">
                {{ $residents->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    let map, markers = [];
    let currentProgramFilter = 'all';
    let currentPurokFilter = 'all';
    
    const programColors = {
        'Pantawid Pamilyang Pilipino Program (4Ps)': '#ef4444',
        'Targeted Cash Transfers (TCT)': '#3b82f6',
        'Sustainable Livelihood Program (SLP)': '#f97316',
        'Assistance to Individuals in Crisis Situations (AICS)': '#eab308'
    };
    
    function createColoredIcon(color) {
        return L.divIcon({
            className: 'custom-marker',
            html: `<svg width="32" height="42" viewBox="0 0 32 42" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 0C7.163 0 0 7.163 0 16c0 12 16 26 16 26s16-14 16-26C32 7.163 24.837 0 16 0z" 
                          fill="${color}" stroke="white" stroke-width="2"/>
                    <circle cx="16" cy="16" r="6" fill="white"/>
                   </svg>`,
            iconSize: [32, 42],
            iconAnchor: [16, 42],
            popupAnchor: [0, -42]
        });
    }
    
    function initResidentsMap() {
        const bagacay = [9.2833, 123.2833];
        
        map = L.map('residentsMap').setView(bagacay, 15);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        
        const residents = @json($residents);
        
        residents.forEach(resident => {
            if (resident.latitude && resident.longitude) {
                const program = resident.is_indigent || 'Unknown';
                const color = programColors[program] || '#6b7280';
                
                const marker = L.marker([parseFloat(resident.latitude), parseFloat(resident.longitude)], {
                    icon: createColoredIcon(color)
                })
                    .addTo(map)
                    .bindPopup(`
                        <div class="p-2">
                            <h3 class="font-medium text-gray-900">${resident.name}</h3>
                            <p class="text-sm text-gray-600">${resident.purok}</p>
                            <p class="text-sm text-gray-500 mt-1">${resident.full_address || 'No address provided'}</p>
                            <p class="text-xs font-medium text-blue-600 mt-2">${program}</p>
                            <p class="text-xs text-gray-400 mt-1">Coordinates: ${resident.latitude}, ${resident.longitude}</p>
                        </div>
                    `);
                
                markers.push({ marker, resident, program, purok: resident.purok });
            }
        });
        
        if (markers.length > 0) {
            const group = new L.featureGroup(markers.map(m => m.marker));
            map.fitBounds(group.getBounds().pad(0.1));
        }
    }
    
    function applyFilters() {
        markers.forEach(({ marker, program, purok }) => {
            const programMatch = currentProgramFilter === 'all' || program === currentProgramFilter;
            const purokMatch = currentPurokFilter === 'all' || purok === currentPurokFilter;
            
            if (programMatch && purokMatch) {
                marker.addTo(map);
            } else {
                map.removeLayer(marker);
            }
        });
        
        const visibleMarkers = markers.filter(({ program, purok }) => {
            const programMatch = currentProgramFilter === 'all' || program === currentProgramFilter;
            const purokMatch = currentPurokFilter === 'all' || purok === currentPurokFilter;
            return programMatch && purokMatch;
        });
        
        if (visibleMarkers.length > 0) {
            const group = new L.featureGroup(visibleMarkers.map(m => m.marker));
            map.fitBounds(group.getBounds().pad(0.1));
        }
    }
    
    function filterByProgram(program) {
        currentProgramFilter = program;
        
        document.querySelectorAll('.filter-btn').forEach(btn => {
            if (btn.dataset.program === program) {
                btn.classList.remove('bg-gray-200', 'text-gray-700');
                btn.classList.add('bg-gray-600', 'text-white');
            } else {
                btn.classList.remove('bg-gray-600', 'text-white', 'bg-red-500', 'bg-blue-500', 'bg-orange-500', 'bg-yellow-500');
                btn.classList.add('bg-gray-200', 'text-gray-700');
            }
        });
        
        applyFilters();
    }
    
    function filterByPurok(purok) {
        currentPurokFilter = purok;
        
        document.querySelectorAll('.purok-btn').forEach(btn => {
            if (btn.dataset.purok === purok) {
                btn.classList.remove('bg-gray-200', 'text-gray-700');
                btn.classList.add('bg-indigo-600', 'text-white');
            } else {
                btn.classList.remove('bg-indigo-600', 'text-white', 'bg-indigo-500');
                btn.classList.add('bg-gray-200', 'text-gray-700');
            }
        });
        
        applyFilters();
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