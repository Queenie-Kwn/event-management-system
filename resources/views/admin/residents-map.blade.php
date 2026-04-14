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
                        @if(($programCounts['Pantawid Pamilyang Pilipino Program (4Ps)'] ?? 0) > 0)
                        <span class="ml-1 bg-red-100 text-red-700 text-xs font-semibold px-1.5 py-0.5 rounded-full">{{ $programCounts['Pantawid Pamilyang Pilipino Program (4Ps)'] }}</span>
                        @endif
                    </button>
                    <button onclick="filterByProgram('Targeted Cash Transfers (TCT)')" class="filter-btn px-4 py-2 rounded-lg font-medium transition-all bg-gray-200 text-gray-700 hover:bg-blue-500 hover:text-white" data-program="Targeted Cash Transfers (TCT)">
                        <span class="inline-block w-3 h-3 rounded-full bg-blue-500 mr-2"></span>TCT
                        @if(($programCounts['Targeted Cash Transfers (TCT)'] ?? 0) > 0)
                        <span class="ml-1 bg-blue-100 text-blue-700 text-xs font-semibold px-1.5 py-0.5 rounded-full">{{ $programCounts['Targeted Cash Transfers (TCT)'] }}</span>
                        @endif
                    </button>
                    <button onclick="filterByProgram('Sustainable Livelihood Program (SLP)')" class="filter-btn px-4 py-2 rounded-lg font-medium transition-all bg-gray-200 text-gray-700 hover:bg-orange-500 hover:text-white" data-program="Sustainable Livelihood Program (SLP)">
                        <span class="inline-block w-3 h-3 rounded-full bg-orange-500 mr-2"></span>SLP
                        @if(($programCounts['Sustainable Livelihood Program (SLP)'] ?? 0) > 0)
                        <span class="ml-1 bg-orange-100 text-orange-700 text-xs font-semibold px-1.5 py-0.5 rounded-full">{{ $programCounts['Sustainable Livelihood Program (SLP)'] }}</span>
                        @endif
                    </button>
                    <button onclick="filterByProgram('Assistance to Individuals in Crisis Situations (AICS)')" class="filter-btn px-4 py-2 rounded-lg font-medium transition-all bg-gray-200 text-gray-700 hover:bg-yellow-500 hover:text-white" data-program="Assistance to Individuals in Crisis Situations (AICS)">
                        <span class="inline-block w-3 h-3 rounded-full bg-yellow-500 mr-2"></span>AICS
                        @if(($programCounts['Assistance to Individuals in Crisis Situations (AICS)'] ?? 0) > 0)
                        <span class="ml-1 bg-yellow-100 text-yellow-700 text-xs font-semibold px-1.5 py-0.5 rounded-full">{{ $programCounts['Assistance to Individuals in Crisis Situations (AICS)'] }}</span>
                        @endif
                    </button>
                </div>
                
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Filter by Purok</h3>
                <div class="flex flex-wrap gap-2">
                    <button onclick="filterByPurok('all')" class="purok-btn px-4 py-2 rounded-lg font-medium transition-all bg-indigo-600 text-white" data-purok="all">
                        All Puroks
                    </button>
                    @foreach(config('puroks') as $name => $coords)
                    <button onclick="filterByPurok('{{ $name }}')" class="purok-btn px-4 py-2 rounded-lg font-medium transition-all bg-gray-200 text-gray-700 hover:bg-indigo-500 hover:text-white" data-purok="{{ $name }}">
                        {{ $name }}
                        @if(($purokCounts[$name] ?? 0) > 0)
                        <span class="ml-1 bg-indigo-100 text-indigo-700 text-xs font-semibold px-1.5 py-0.5 rounded-full purok-badge">{{ $purokCounts[$name] }}</span>
                        @endif
                    </button>
                    @endforeach
                </div>

                <!-- Purok Summary Bar -->
                <div id="purokSummary" class="hidden mt-4 p-4 bg-indigo-50 border border-indigo-200 rounded-xl flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-indigo-600 rounded-lg flex items-center justify-center">
                            <i data-feather="map-pin" class="w-5 h-5 text-white"></i>
                        </div>
                        <div>
                            <p class="text-xs text-indigo-500 font-medium">Selected Purok</p>
                            <p id="summaryPurokName" class="text-base font-bold text-indigo-900"></p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-indigo-500 font-medium">Total Members</p>
                        <p id="summaryMemberCount" class="text-3xl font-extrabold text-indigo-700"></p>
                    </div>
                </div>
            </div>
            
            <!-- Map Container -->
            <div id="residentsMap" class="w-full h-[500px] bg-gray-200 rounded-xl mb-6 relative z-0"></div>
            
            <!-- Residents List -->
            <div id="residentCards" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @forelse($residents as $resident)
                <div class="resident-card bg-gray-50 rounded-xl p-4 hover:bg-gray-100 transition-colors {{ $resident->latitude && $resident->longitude ? 'cursor-pointer' : '' }}" 
                     data-program="{{ $resident->is_indigent }}"
                     data-purok="{{ $resident->purok }}"
                     @if($resident->latitude && $resident->longitude)
                     onclick="focusOnResident({{ $resident->latitude }}, {{ $resident->longitude }})"
                     @endif>
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-medium text-gray-900">{{ $resident->name }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ $resident->purok }}</p>
                            <p class="text-xs text-blue-600 mt-1">{{ $resident->is_indigent ?? 'No Program' }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ $resident->full_address ?? 'No address provided' }}</p>
                        </div>
                        <div class="text-right text-xs text-gray-400">
                            @if($resident->latitude && $resident->longitude)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-green-100 text-green-700 mb-1">
                                    📍 Mapped
                                </span>
                                <p>{{ $resident->latitude }}, {{ $resident->longitude }}</p>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-500">
                                    No location
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-2 text-center py-12" id="emptyState">
                    <i data-feather="map-pin" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Geo-tagged Residents</h3>
                    <p class="text-gray-500">Residents with location data will appear here</p>
                </div>
                @endforelse
            </div>
            <div id="noFilterResults" class="col-span-2 text-center py-12 hidden">
                <i data-feather="filter" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Matching Residents</h3>
                <p class="text-gray-500">No residents match the selected filters</p>
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
    const purokCounts = @json($purokCounts);

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
        const bagacay = [9.300472, 123.293472]; // Barangay Bagacay center
        
        map = L.map('residentsMap').setView(bagacay, 15);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        
        const residents = @json($allResidents);
        
        residents.forEach(resident => {
            if (resident.latitude && resident.longitude) {
                const program = resident.is_indigent ?? 'Unknown';
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
    
    function normalizePurok(purok) {
        return purok.toLowerCase().replace(/^purok\s+/i, '').trim();
    }

    function purokMatch(stored, filter) {
        if (filter === 'all') return true;
        return normalizePurok(stored) === normalizePurok(filter);
    }

    function applyFilters() {
        const visibleMarkers = [];

        markers.forEach(({ marker, program, purok }) => {
            const programMatches = currentProgramFilter === 'all' || program === currentProgramFilter;
            const purokMatches = purokMatch(purok, currentPurokFilter);
            
            if (programMatches && purokMatches) {
                marker.addTo(map);
                visibleMarkers.push({ marker });
            } else {
                map.removeLayer(marker);
            }
        });
        
        if (visibleMarkers.length > 0) {
            const group = new L.featureGroup(visibleMarkers.map(m => m.marker));
            map.fitBounds(group.getBounds().pad(0.1));
        }

        // Filter resident cards
        let visibleCards = 0;
        document.querySelectorAll('.resident-card').forEach(card => {
            const programMatches = currentProgramFilter === 'all' || card.dataset.program === currentProgramFilter;
            const purokMatches = purokMatch(card.dataset.purok, currentPurokFilter);
            if (programMatches && purokMatches) {
                card.style.display = '';
                visibleCards++;
            } else {
                card.style.display = 'none';
            }
        });

        const noResults = document.getElementById('noFilterResults');
        if (noResults) noResults.classList.toggle('hidden', visibleCards > 0);
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
                // fix badge color when active
                btn.querySelectorAll('.purok-badge').forEach(b => {
                    b.classList.remove('bg-indigo-100', 'text-indigo-700');
                    b.classList.add('bg-white', 'text-indigo-700');
                });
            } else {
                btn.classList.remove('bg-indigo-600', 'text-white', 'bg-indigo-500');
                btn.classList.add('bg-gray-200', 'text-gray-700');
                btn.querySelectorAll('.purok-badge').forEach(b => {
                    b.classList.remove('bg-white');
                    b.classList.add('bg-indigo-100', 'text-indigo-700');
                });
            }
        });

        const summary = document.getElementById('purokSummary');
        if (purok === 'all') {
            summary.classList.add('hidden');
        } else {
            document.getElementById('summaryPurokName').textContent = purok;
            document.getElementById('summaryMemberCount').textContent = purokCounts[purok] ?? 0;
            summary.classList.remove('hidden');
            feather.replace();
        }
        
        applyFilters();
    }
    
    function focusOnResident(lat, lng) {
        map.setView([parseFloat(lat), parseFloat(lng)], 18);
        
        const found = markers.find(m => 
            Math.abs(m.marker.getLatLng().lat - parseFloat(lat)) < 0.0001 && 
            Math.abs(m.marker.getLatLng().lng - parseFloat(lng)) < 0.0001
        );
        
        if (found) found.marker.openPopup();
    }
    
    // Initialize map when page loads
    document.addEventListener('DOMContentLoaded', function() {
        initResidentsMap();
    });
    
    feather.replace();
</script>
@endsection