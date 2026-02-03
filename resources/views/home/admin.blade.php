<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="flex min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">

    @include('partials.splash')

    <!-- Mobile menu button -->
    <button id="mobileMenuBtn" class="lg:hidden fixed top-4 left-4 z-50 bg-gradient-to-r from-blue-600 to-blue-700 text-white p-3 rounded-2xl shadow-lg">
        <i data-feather="menu" class="w-5 h-5"></i>
    </button>

    <!-- Sidebar -->
    <div id="sidebar" class="w-72 bg-white/90 backdrop-blur-sm border-r border-white/20 flex-shrink-0 shadow-xl fixed left-0 top-0 h-screen overflow-y-auto transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-40">
        <div class="p-8 text-center">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-blue-800 rounded-full flex items-center justify-center mb-4 mx-auto shadow-lg">
                <i data-feather="map-pin" class="w-8 h-8 text-white"></i>
            </div>
            <h2 class="text-lg font-bold text-slate-800 mb-1">Barangay Bagacay</h2>
            <p class="text-sm text-slate-500 font-light">Management System</p>
        </div>

        <nav class="px-6 space-y-2">
            <a href="#" class="flex items-center gap-3 py-3 px-4 rounded-2xl text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200">
                <i data-feather="home" class="w-5 h-5"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            <a href="{{ route('dashboard.document-requests') }}" class="flex items-center gap-3 py-3 px-4 rounded-2xl {{ request()->routeIs('dashboard.document-requests') ? 'bg-blue-100 text-blue-700' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }} transition-all duration-200">
                <i data-feather="file-text" class="w-5 h-5"></i>
                <span class="font-medium">Document Requests</span>
            </a>
        </nav>

        @php
            $documentsOpen =
                request()->routeIs('dashboard.portal') ||
                request()->routeIs('dashboard.agriculture') ||
                request()->routeIs('dashboard.barangay-certification') ||
                request()->routeIs('dashboard.business-certification') ||
                request()->routeIs('dashboard.good-moral-certification') ||
                request()->routeIs('events.*');

            $usersOpen =
                request()->routeIs('dashboard-residents.*') ||
                request()->routeIs('add-user.*');
        @endphp


        <div class="px-6 mt-6">
            <button onclick="toggleRequest()" class="w-full flex justify-between items-center text-left py-3 px-4 rounded-2xl text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200">
                <div class="flex items-center gap-3">
                    <i data-feather="folder" class="w-5 h-5"></i>
                    <span class="font-medium">Create Documents</span>
                </div>
                <i data-feather="chevron-down" id="requestIcon" class="w-4 h-4 transition-transform duration-300 {{ $documentsOpen ? 'rotate-180' : '' }}"></i>
            </button>

            <div id="requestMenu" class="ml-8 mt-2 space-y-1 overflow-hidden transition-all duration-300 {{ $documentsOpen ? 'max-h-96' : 'max-h-0' }}">
                <a href="{{ route('dashboard.portal') }}" class="flex items-center gap-3 py-2 px-4 rounded-xl text-sm {{ request()->routeIs('dashboard.portal') ? 'bg-blue-100 text-blue-700' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }} transition-all duration-200">
                    <i data-feather="file" class="w-4 h-4"></i>
                    <span>Indigency</span>
                </a>

                <a href="{{ route('dashboard.agriculture') }}" class="flex items-center gap-3 py-2 px-4 rounded-xl text-sm {{ request()->routeIs('dashboard.agriculture') ? 'bg-blue-100 text-blue-700' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }} transition-all duration-200">
                    <i data-feather="sun" class="w-4 h-4"></i>
                    <span>Agricultural Certification</span>
                </a>

                <a href="{{ route('dashboard.barangay-certification') }}" class="flex items-center gap-3 py-2 px-4 rounded-xl text-sm {{ request()->routeIs('dashboard.barangay-certification') ? 'bg-blue-100 text-blue-700' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }} transition-all duration-200">
                    <i data-feather="award" class="w-4 h-4"></i>
                    <span>Barangay Certification</span>
                </a>

                <a href="{{ route('dashboard.business-certification') }}" class="flex items-center gap-3 py-2 px-4 rounded-xl text-sm {{ request()->routeIs('dashboard.business-certification') ? 'bg-blue-100 text-blue-700' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }} transition-all duration-200">
                    <i data-feather="briefcase" class="w-4 h-4"></i>
                    <span>Business Certification</span>
                </a>

                <a href="{{ route('dashboard.good-moral-certification') }}" class="flex items-center gap-3 py-2 px-4 rounded-xl text-sm {{ request()->routeIs('dashboard.good-moral-certification') ? 'bg-blue-100 text-blue-700' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }} transition-all duration-200">
                    <i data-feather="check-circle" class="w-4 h-4"></i>
                    <span>Certificate of Good Moral</span>
                </a>
            </div>
        </div>

        <div class="px-6 mt-4">
            <button onclick="toggleRequestUser()" class="w-full flex justify-between items-center text-left py-3 px-4 rounded-2xl text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200">
                <div class="flex items-center gap-3">
                    <i data-feather="users" class="w-5 h-5"></i>
                    <span class="font-medium">User Management</span>
                </div>
                <i data-feather="chevron-down" id="requestIcongg" class="w-4 h-4 transition-transform duration-300 {{ $usersOpen ? 'rotate-180' : '' }}"></i>
            </button>

            <div id="requestMenuNice" class="ml-8 mt-2 space-y-1 overflow-hidden transition-all duration-300 {{ $usersOpen ? 'max-h-40' : 'max-h-0' }}">
                <a href="{{ route('dashboard-residents.residents') }}" class="flex items-center gap-3 py-2 px-4 rounded-xl text-sm {{ request()->routeIs('dashboard-residents.*') ? 'bg-blue-100 text-blue-700' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }} transition-all duration-200">
                    <i data-feather="user" class="w-4 h-4"></i>
                    <span>Residents</span>
                </a>

                <a href="{{ route('add-user.portal') }}" class="flex items-center gap-3 py-2 px-4 rounded-xl text-sm {{ request()->routeIs('add-user.*') ? 'bg-blue-100 text-blue-700' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }} transition-all duration-200">
                    <i data-feather="user-plus" class="w-4 h-4"></i>
                    <span>Add Residents</span>
                </a>
            </div>
        </div>


    </div>

    <!-- Main content -->
    <main class="flex-1 lg:ml-72 ml-0">
        <!-- Header -->
        <header class="bg-white/80 backdrop-blur-sm border-b border-white/20 shadow-sm p-6 mb-8 flex justify-between items-center">
            <h1 class="text-2xl lg:text-3xl font-bold text-slate-800 tracking-tight">Barangay Bagacay Management System</h1>

            <div class="flex items-center gap-6">
                <div class="text-right">
                    <p class="text-sm font-medium text-slate-800">{{ Auth::user()->name ?? 'Administrator' }}</p>
                    <p class="text-xs text-slate-500" id="philippineTime"></p>
                </div>
                
                <div class="relative">
                    <button id="profileBtn" class="flex items-center gap-3 p-2 rounded-2xl hover:bg-blue-50 transition-all duration-200 focus:outline-none">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-800 rounded-full flex items-center justify-center">
                            <i data-feather="user" class="w-5 h-5 text-white"></i>
                        </div>
                        <i data-feather="chevron-down" class="w-4 h-4 text-slate-600"></i>
                    </button>

                    <div id="profileDropdown" class="absolute right-0 mt-2 w-40 bg-white/90 backdrop-blur-sm border border-white/20 rounded-2xl shadow-xl py-2 hidden">
                        <a href="{{ route('welcome-portal') }}" class="flex items-center gap-2 px-4 py-3 text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200">
                            <i data-feather="log-out" class="w-4 h-4"></i>
                            <span class="font-medium">Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <script>
            feather.replace();
            
            // Philippine Time Display
            function updatePhilippineTime() {
                const now = new Date();
                const philippineTime = new Intl.DateTimeFormat('en-PH', {
                    timeZone: 'Asia/Manila',
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                }).format(now);
                document.getElementById('philippineTime').textContent = philippineTime;
            }
            
            updatePhilippineTime();
            setInterval(updatePhilippineTime, 1000);
            
            // Clear all text inputs on page load
            window.addEventListener('load', function() {
                const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="number"], textarea');
                inputs.forEach(input => {
                    input.value = '';
                });
            });

            // Clear all text inputs after form submission
            document.addEventListener('DOMContentLoaded', function() {
                const forms = document.querySelectorAll('form');
                forms.forEach(form => {
                    form.addEventListener('submit', function() {
                        setTimeout(() => {
                            const inputs = form.querySelectorAll('input[type="text"], input[type="email"], input[type="number"], textarea');
                            inputs.forEach(input => {
                                input.value = '';
                            });
                        }, 100);
                    });
                });
            });

            // Mobile menu toggle
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const sidebar = document.getElementById('sidebar');

            mobileMenuBtn.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', (e) => {
                if (window.innerWidth < 1024 &&
                    !sidebar.contains(e.target) &&
                    !mobileMenuBtn.contains(e.target) &&
                    !e.target.closest('button[onclick]')) {
                    sidebar.classList.add('-translate-x-full');
                }
            });

            // Get elements
            const profileBtn = document.getElementById('profileBtn');
            const profileDropdown = document.getElementById('profileDropdown');

            // Toggle dropdown on click
            profileBtn.addEventListener('click', () => {
                profileDropdown.classList.toggle('hidden');
            });

            // Optional: close dropdown if clicked outside
            window.addEventListener('click', function(e) {
                if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });

            function toggleRequest() {
                const menu = document.getElementById('requestMenu');
                const icon = document.getElementById('requestIcon');

                if (menu.classList.contains('max-h-0')) {
                    menu.classList.remove('max-h-0');
                    menu.classList.add('max-h-96');
                    icon.classList.add('rotate-180');
                } else {
                    menu.classList.add('max-h-0');
                    menu.classList.remove('max-h-96');
                    icon.classList.remove('rotate-180');
                }
            }

            function toggleRequestUser() {
                const menu = document.getElementById('requestMenuNice');
                const icon = document.getElementById('requestIcongg');

                if (menu.classList.contains('max-h-0')) {
                    menu.classList.remove('max-h-0');
                    menu.classList.add('max-h-40');
                    icon.classList.add('rotate-180');
                } else {
                    menu.classList.add('max-h-0');
                    menu.classList.remove('max-h-40');
                    icon.classList.remove('rotate-180');
                }
            }
        </script>

        @yield('content')

    </main>

</body>
</html>
