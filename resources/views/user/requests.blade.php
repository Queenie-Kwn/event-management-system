<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Document Requests - Barangay Bagacay</title>
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
                        <a href="{{ route('user.dashboard') }}" class="mr-4 text-gray-500 hover:text-gray-700">
                            <i data-feather="arrow-left" class="w-5 h-5"></i>
                        </a>
                        <img src="{{ asset('images/barangay_logo.jpg') }}" alt="Logo" class="w-10 h-10 rounded-full mr-3">
                        <div>
                            <h1 class="text-xl font-semibold text-gray-900">My Document Requests</h1>
                            <p class="text-sm text-gray-500">Track your document status</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-700">{{ Auth::user()->name }}</span>
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
            @if($requests->count() > 0)
                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <ul class="divide-y divide-gray-200">
                        @foreach($requests as $request)
                            <li class="px-6 py-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <i data-feather="file-text" class="w-6 h-6 text-gray-600"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $request->purpose ?? 'Document Request' }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                Requested on {{ $request->created_at->format('M d, Y') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        @if($request->status == 'approved')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i data-feather="check" class="w-3 h-3 mr-1"></i>
                                                Ready for Pickup
                                            </span>
                                        @elseif($request->status == 'rejected')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i data-feather="x" class="w-3 h-3 mr-1"></i>
                                                Rejected
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i data-feather="clock" class="w-3 h-3 mr-1"></i>
                                                Pending Review
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div class="text-center py-12">
                    <i data-feather="file-text" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Document Requests</h3>
                    <p class="text-gray-500 mb-4">You haven't requested any documents yet.</p>
                    <a href="{{ route('user.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Request Documents
                    </a>
                </div>
            @endif
        </main>
    </div>

    <script>
        feather.replace();
    </script>
</body>
</html>