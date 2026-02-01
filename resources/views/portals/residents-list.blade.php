@extends('home.admin')

@section('title', 'Residents List')

@section('content')

<div class="max-w-7xl mx-auto px-6">

    <!-- PAGE HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Residents List</h2>
    </div>

    <!-- SEARCH & FILTER -->
    <div class="bg-white p-4 rounded shadow mb-6 flex flex-wrap gap-4 items-center">

        <!-- Search -->
        <input
            type="text"
            id="searchInput"
            placeholder="Search name or email..."
            class="border rounded px-4 py-2 w-64"
            onkeyup="filterTable()"
        >

        <!-- Filter Role -->
        <select
            id="roleFilter"
            onchange="filterTable()"
            class="border rounded px-4 py-2"
        >
            <option value="">All Roles</option>
            <option value="resident">Resident</option>
            <option value="admin">Admin</option>
        </select>


    <!-- TABLE -->


        <table class="min-w-full border-collapse">
            <thead class="bg-gray-100 text-gray-700 text-sm uppercase">
                <tr>
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Age</th>
                    <th class="px-4 py-3 text-left">Civil Status</th>
                    <th class="px-4 py-3 text-left">Purok</th>
                    <th class="px-4 py-3 text-left">Role</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>

            <tbody id="residentsTable" class="text-gray-800">

                @forelse ($residents as $resident)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $resident->name }}</td>
                        <td class="px-4 py-2">{{ $resident->email }}</td>
                        <td class="px-4 py-2">{{ $resident->age ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $resident->civil_status }}</td>
                        <td class="px-4 py-2">{{ $resident->purok }}</td>
                        <td class="px-4 py-2 capitalize">{{ $resident->role }}</td>
                        <td class="px-4 py-2 text-center">
                            <a href="#" class="text-blue-600 hover:underline text-sm">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                            No residents found.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
</div>
</div>

<!-- SIMPLE SEARCH + FILTER SCRIPT -->
<script>
function filterTable() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const role = document.getElementById('roleFilter').value.toLowerCase();
    const rows = document.querySelectorAll('#residentsTable tr');

    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        const rowRole = row.children[5]?.innerText.toLowerCase();

        const matchesSearch = text.includes(search);
        const matchesRole = role === '' || rowRole === role;

        row.style.display = (matchesSearch && matchesRole) ? '' : 'none';
    });
}
</script>

@endsection
