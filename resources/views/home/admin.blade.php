<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex min-h-screen bg-gray-100">

    <!-- Mobile menu button -->
    <button id="mobileMenuBtn" class="lg:hidden fixed top-4 left-4 z-50 bg-[#0b2c5f] text-white p-2 rounded">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    <!-- Sidebar -->
    <div id="sidebar" class="w-64 bg-[#0b2c5f] text-white flex-shrink-0 shadow-xl fixed left-0 top-0 h-screen overflow-y-auto transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-40">
        <div class="p-6 text-center gap-3">
            <img src="{{ asset('images/barangay_logo.jpg') }}"
                alt="Bagacay Logo"
                class="w-26 h-26 object-contain">
        </div>

         <nav>
            <a href="#"
            class="block py-2 px-6">
                Dashboard
            </a>

             <a href="{{ route('dashboard.document-requests') }}"
            class="block py-2 px-6 {{ request()->routeIs('dashboard.document-requests') ? 'bg-blue-400' : 'hover:bg-blue-700' }}">
                Document Requests
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


        <div class="px-4 mt-4">

            <button
                onclick="toggleRequest()"
                class="w-full flex justify-between items-center text-left text-sm uppercase tracking-wide text-white py-2 px-2 hover:text-white"
            >
                Create Documents
                <svg id="requestIcon"
                    class="w-4 h-4 transition-transform duration-300 {{ $documentsOpen ? 'rotate-180' : '' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div id="requestMenu"
                class="ml-4 mt-2 space-y-1 overflow-y-auto transition-all duration-300
                {{ $documentsOpen ? 'max-h-96' : 'max-h-0' }}">

              <a href="{{ route('dashboard.portal') }}"
                class="flex items-center gap-2 py-2 px-4 rounded
                {{ request()->routeIs('dashboard.portal') ? 'bg-blue-400 text-white' : 'hover:bg-blue-700' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v14l-4-2-4 2-4-2-4 2V6a2 2 0 012-2z"/>
                    </svg>
                    Indigency
                </a>


             <a href="{{ route('dashboard.agriculture') }}"
                class="flex items-center gap-2 py-2 px-4 rounded
                {{ request()->routeIs('dashboard.agriculture') ? 'bg-blue-400 text-white' : 'hover:bg-blue-700' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-3.866 0-7 3.134-7 7m14 0c0-3.866-3.134-7-7-7zm0 0V3m0 5l-2-2m2 2l2-2"/>
                    </svg>
                    Agricultural Certification
                </a>


                      <a href="{{ route('dashboard.barangay-certification') }}"
                        class="flex items-center gap-2 py-2 px-4 rounded
                        {{ request()->routeIs('dashboard.barangay-certification') ? 'bg-blue-400 text-white' : 'hover:bg-blue-700' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v14l-4-2-4 2-4-2-4 2V6a2 2 0 012-2z"/>
                            </svg>
                            Barangay Certification
                        </a>


                       <a href="{{ route('dashboard.business-certification') }}"
                        class="flex items-center gap-2 py-2 px-4 rounded
                        {{ request()->routeIs('dashboard.business-certification') ? 'bg-blue-400 text-white' : 'hover:bg-blue-700' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7h18M5 7V5a2 2 0 012-2h10a2 2 0 012 2v2M4 7v13h16V7"/>
                            </svg>
                            Business Certification
                        </a>


                       <a href="{{ route('dashboard.good-moral-certification') }}"
                        class="flex items-center gap-2 py-2 px-4 rounded mb-4
                        {{ request()->routeIs('dashboard.good-moral-certification') ? 'bg-blue-400 text-white' : 'hover:bg-blue-700' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Certificate of Good Moral
                        </a>

            </div>
        </div>

        <div class="px-4 mt-4">
            <button
                onclick="toggleRequestUser()"
                class="w-full flex justify-between items-center text-left text-sm uppercase tracking-wide text-white py-2 px-2 hover:text-white"
            >
                User Management
                <svg id="requestIcongg"
                    class="w-4 h-4 transition-transform duration-300 {{ $documentsOpen ? 'rotate-180' : '' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 9l-7 7-7-7" />
                </svg>
            </button>



            <div id="requestMenuNice"
                class="ml-4 mt-2 space-y-1 overflow-hidden transition-all duration-300
                {{ $documentsOpen ? 'max-h-40' : 'max-h-0' }}">


                 <a href="{{ route('dashboard-residents.residents') }}"
                    class="flex items-center gap-2 py-2 px-4 rounded
                    {{ request()->routeIs('dashboard-residents.*') ? 'bg-blue-400 text-white' : 'hover:bg-blue-700' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Residents
                    </a>


                 <a href="{{ route('add-user.portal') }}"
                    class="flex items-center gap-2 py-2 px-4 rounded
                    {{ request()->routeIs('add-user.*') ? 'bg-blue-400 text-white' : 'hover:bg-blue-700' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Residents
                    </a>


            </div>
        </div>

        <br>


    </div>

    <!-- Main content -->
    <main class="flex-1 lg:ml-64 ml-0">
        <!-- Header -->
       <header class="shadow p-4 mb-6 flex justify-between items-center bg-white">
            <!-- Header Title -->
            <h1 class="text-xl lg:text-2xl font-bold text-gray-800">BARANGAY BAGACAY MANAGEMENT SYSTEM</h1>

            <!-- Profile Dropdown -->
            <div class="relative">
                <button id="profileBtn" class="flex items-center space-x-2 focus:outline-none">
                    <!-- Profile Picture -->
                    <img src="images/profile_logo.avif" alt="Profile" class="w-14 h-14">
                    <!-- Down arrow icon -->
                    <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div id="profileDropdown" class="absolute right-0 mt-2 w-32 bg-white border rounded shadow-lg py-1 hidden">
                    <a href="{{ route('welcome-portal') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>
                </div>
            </div>
        </header>

        <script>
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
        </script>

        <script>
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
        </script>

          <script>
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
