@extends('home.admin')

@section('title', 'Dashboard')

@section('content')



<div class="max-w-5xl mx-auto bg-white shadow-lg rounded-lg p-8">

    <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center mb-6">
        Register Resident
    </h2>

    <form class="grid grid-cols-1 md:grid-cols-2 gap-6">

        
        <!-- Full Name (NOW 2ND COLUMN) -->
       


        <!-- Name -->
      <form class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Profile Upload (LEFT COLUMN) -->
         
        <div class="md:row-span-3 flex flex-col items-start justify-start">

            <div class="w-32 h-32 rounded-full border-2 border-dashed border-gray-300 flex items-center justify-center mb-3 overflow-hidden">
                <img id="photoPreview"
                    class="hidden w-full h-full object-cover"
                    alt="Profile Preview">

                <span id="photoPlaceholder" class="text-gray-400 text-sm text-center">
                    Profile Photo
                </span>
            </div>



           <input type="file"
            accept="image/*"
            onchange="previewPhoto(event)"
            class="block w-full text-sm text-gray-600
            file:mr-4 file:py-2 file:px-4
            file:rounded-md file:border-0
            file:bg-blue-600 file:text-white
            hover:file:bg-blue-700">


                <br>             
                    <label class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text"
                        class="mt-1 w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
        </div>

        <!-- Full Name (NOW 2ND COLUMN) -->
       


        <!-- Email -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email"
                   class="mt-1 w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
        </div>

        <!-- Password -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password"
                   class="mt-1 w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
        </div>

        <!-- Role -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Role</label>
            <select
                class="mt-1 w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
                <option value="">Select role</option>
                <option>Resident</option>
                <option>Admin</option>
            </select>
        </div>

        <!-- Age -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Age</label>
            <input type="number"
                   class="mt-1 w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
        </div>

        <!-- Civil Status -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Civil Status</label>
            <select
                class="mt-1 w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
                <option value="">Select status</option>
                <option>Single</option>
                <option>Married</option>
                <option>Widowed</option>
                <option>Separated</option>
            </select>
        </div>

        <!-- Purok -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Purok</label>
            <input type="text"
                   class="mt-1 w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
        </div>

        <!-- Barangay -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Barangay</label>
            <input type="text" value="Bagacay" readonly
                   class="mt-1 w-full border bg-gray-100 rounded-md px-3 py-2">
        </div>

        <!-- City -->
        <div>
            <label class="block text-sm font-medium text-gray-700">City</label>
            <input type="text" value="Dumaguete City" readonly
                   class="mt-1 w-full border bg-gray-100 rounded-md px-3 py-2">
        </div>

        <!-- Indigent -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Indigent</label>
            <select
                class="mt-1 w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
                <option value="">Select</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>

        <!-- Purpose -->
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Purpose</label>
            <textarea rows="3"
                      class="mt-1 w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"></textarea>
        </div>

        <!-- Date Issued -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Date Issued</label>
            <input type="date"
                   class="mt-1 w-full border rounded-md px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
        </div>

        <!-- Buttons -->
        <div class="md:col-span-2 flex justify-end gap-4 mt-6">
            <a href="{{ url()->previous() }}"
               class="px-6 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-100">
                Cancel
            </a>

            <button type="button"
                    class="px-6 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700">
                Register Resident
            </button>
        </div>

    </form>
</div>

<script>
    function previewPhoto(event) {
        const img = document.getElementById('photoPreview');
        const placeholder = document.getElementById('photoPlaceholder');

        const file = event.target.files[0];
        if (!file) return;

        img.src = URL.createObjectURL(file);
        img.classList.remove('hidden');
        placeholder.classList.add('hidden');
    }
</script>


@endsection
