<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Barangay Bagacay</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center">
                        <img src="{{ asset('images/barangay_logo.jpg') }}" alt="Logo" class="w-10 h-10 rounded-full mr-3">
                        <div>
                            <h1 class="text-xl font-semibold text-gray-900">Barangay Bagacay</h1>
                            <p class="text-sm text-gray-500">Resident Portal</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-700">Welcome, {{ $user->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-sm text-red-600 hover:text-red-800">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Welcome Section -->
            <div class="bg-white overflow-hidden shadow rounded-lg mb-6">
                <div class="px-4 py-5 sm:p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Welcome to Your Dashboard</h2>
                    <p class="text-gray-600">Manage your documents and requests from Barangay Bagacay.</p>
                </div>
            </div>

            <!-- User Info Card -->
            <div class="bg-white overflow-hidden shadow rounded-lg mb-6">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Your Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Full Name</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Email</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Age</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->age }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Civil Status</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->civil_status }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Purok</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->purok }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Barangay</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->barangay }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Available Services</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Request Documents Section -->
                        <div class="col-span-full">
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center mb-4">
                                    <i data-feather="file-text" class="w-8 h-8 text-blue-600 mr-3"></i>
                                    <h4 class="font-medium text-gray-900 text-lg">Request Documents</h4>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                    <a href="#" class="flex items-center gap-3 py-3 px-4 rounded-xl text-sm bg-gray-50 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200">
                                        <i data-feather="file" class="w-4 h-4 text-blue-600"></i>
                                        <span>Indigency</span>
                                    </a>
                                    <a href="#" class="flex items-center gap-3 py-3 px-4 rounded-xl text-sm bg-gray-50 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200">
                                        <i data-feather="sun" class="w-4 h-4 text-green-600"></i>
                                        <span>Agricultural Certification</span>
                                    </a>
                                    <a href="#" class="flex items-center gap-3 py-3 px-4 rounded-xl text-sm bg-gray-50 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200">
                                        <i data-feather="award" class="w-4 h-4 text-purple-600"></i>
                                        <span>Barangay Certification</span>
                                    </a>
                                    <a href="#" class="flex items-center gap-3 py-3 px-4 rounded-xl text-sm bg-gray-50 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200">
                                        <i data-feather="briefcase" class="w-4 h-4 text-orange-600"></i>
                                        <span>Business Certification</span>
                                    </a>
                                    <a href="#" class="flex items-center gap-3 py-3 px-4 rounded-xl text-sm bg-gray-50 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200">
                                        <i data-feather="check-circle" class="w-4 h-4 text-teal-600"></i>
                                        <span>Certificate of Good Moral</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Other Services -->
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 cursor-pointer">
                            <i data-feather="calendar" class="w-8 h-8 text-green-600 mb-2"></i>
                            <h4 class="font-medium text-gray-900">Events</h4>
                            <p class="text-sm text-gray-500">View upcoming barangay events</p>
                        </div>
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 cursor-pointer">
                            <i data-feather="help-circle" class="w-8 h-8 text-purple-600 mb-2"></i>
                            <h4 class="font-medium text-gray-900">Support</h4>
                            <p class="text-sm text-gray-500">Get help and assistance</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        feather.replace();
    </script>
</body>
</html>