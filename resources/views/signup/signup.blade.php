<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b2c5f] flex items-center justify-center min-h-screen">

  <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Sign Up</h2>

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


    
    <form action="{{ route('signup.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="full_name" class="block text-gray-700 mb-1">Full Name</label>
            <input type="text" name="full_name" id="full_name" placeholder="Enter your full name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
        </div>

        <div>
            <label for="email" class="block text-gray-700 mb-1">Email</label>
            <input type="email" name="email" id="email" placeholder="Enter your email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
        </div>

        <div>
            <label for="password" class="block text-gray-700 mb-1">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter your password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="age" class="block text-gray-700 mb-1">Age</label>
                <input type="number" name="age" id="age" placeholder="Age" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
            </div>
            <div>
                <label for="civil_status" class="block text-gray-700 mb-1">Civil Status</label>
                <select name="civil_status" id="civil_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
                    <option value="">Select Status</option>
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                    <option value="Divorced">Divorced</option>
                    <option value="Widowed">Widowed</option>
                </select>
            </div>
        </div>

        <div>
            <label for="purok" class="block text-gray-700 mb-1">Purok</label>
            <input type="text" name="purok" id="purok" placeholder="Enter your purok" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
        </div>

        <div>
            <label for="indigent_status" class="block text-gray-700 mb-1">Indigent Status</label>
            <select name="indigent_status" id="indigent_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" required>
                <option value="">Select Status</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>

        <button type="submit" class="w-full bg-[#0b2c5f] text-white py-2 rounded-lg hover:bg-blue-800 transition-colors">Sign Up</button>
        <a href="{{ url('/') }}" class="w-full inline-block text-center bg-[#0b2c5f] text-white py-2 rounded-lg hover:bg-blue-800 transition-colors">
            Return to Login
        </a>
    </form>

  </div>

</body>
</html>
