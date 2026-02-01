<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Administrator </title>
</head>
<body class="bg-[#0b2c5f] min-h-screen flex items-center justify-center p-4">

  <div class="bg-white w-full max-w-sm rounded-2xl shadow-lg p-8">

   <div class="flex flex-col items-center mb-6">
      <img
          src="{{ asset('images/barangay_logo.jpg') }}"
          alt="Barangay Bagacay Logo"
          class="w-20 h-20 object-contain mb-3"
      >
      <h1 class="text-xl font-semibold text-gray-700 text-center">
          Barangay Bagacay Management System
      </h1>
      <p class="text-sm text-gray-500">Login</p>
  </div>


    <h2 class="text-lg font-medium text-gray-700 mb-4 border-b pb-2">Administrator Login</h2>

    @if(session('success'))
          <script>alert("{{ session('success') }}");</script>
      @endif

      @if(session('error'))
          <script>alert("{{ session('error') }}");</script>
      @endif

      @if($errors->any())
          <script>
              let messages = "";
              @foreach($errors->all() as $error)
                  messages += "{{ $error }}\n";
              @endforeach
              alert(messages);
          </script>
    @endif

    <form action="{{ route('login.user') }}" method="POST" class="space-y-4">
      @csrf
      <div>
          <input
            type="text"
            name="username"
            placeholder="Username or Email"
            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-700"
            required
          />
      </div>
      <div>
          <input
            type="password"
            name="password"
            placeholder="Password"
            class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-700"
            required
          />
      </div>
      <button
          type="submit"
          class="w-full bg-blue-900 text-white py-2 rounded-lg hover:bg-blue-800 transition"
      >
          Sign In
      </button>
    </form>

    <p class="text-center text-xs text-gray-500 mt-4">
      To Signup , Please click this link  
      <a href="{{ route('signup-portal') }}" class="text-blue-600 hover:underline">Administrator</a>'s Signup Portal
    </p>

    <div class="text-center mt-6">
      <p class="text-xs text-gray-400">System powered by</p>
      <div class="w-26 h-4 bg-gray-800 rounded mx-auto mt-1 text-xs text-white">Negros Oriental State University</div>
    </div>

  </div>
  
</body>
</html>
