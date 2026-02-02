<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up - Barangay Bagacay</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/feather-icons"></script>
  <style>
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen flex items-center justify-center p-4 sm:p-6">

  <div class="bg-white/80 backdrop-blur-sm w-full max-w-5xl rounded-3xl shadow-xl border border-white/20 p-6 sm:p-8">

   <div class="flex flex-col items-center mb-6">
      <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-blue-600 to-blue-800 rounded-full flex items-center justify-center mb-4 shadow-lg">
        <img
            src="{{ asset('images/barangay_logo.jpg') }}"
            alt="Barangay Logo"
            class="w-10 h-10 sm:w-12 sm:h-12 object-contain rounded-full"
        >
      </div>
      <h1 class="text-2xl sm:text-3xl font-bold text-slate-800 text-center mb-2 tracking-tight">
          Create Account
      </h1>
      <p class="text-xs text-slate-500 font-light">Join Barangay Bagacay</p>
  </div>

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
        <div class="grid grid-cols-3 gap-4">
            <div>
                <label for="first_name" class="block text-sm font-medium text-slate-700 mb-2">First Name</label>
                <input type="text" name="first_name" id="first_name" placeholder="First Name" class="w-full bg-slate-50/50 border-0 rounded-2xl px-4 py-3 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200" required>
            </div>
            <div>
                <label for="middle_name" class="block text-sm font-medium text-slate-700 mb-2">Middle Name</label>
                <input type="text" name="middle_name" id="middle_name" placeholder="Middle Name" class="w-full bg-slate-50/50 border-0 rounded-2xl px-4 py-3 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200">
            </div>
            <div>
                <label for="last_name" class="block text-sm font-medium text-slate-700 mb-2">Last Name</label>
                <input type="text" name="last_name" id="last_name" placeholder="Last Name" class="w-full bg-slate-50/50 border-0 rounded-2xl px-4 py-3 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200" required>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label for="suffix" class="block text-sm font-medium text-slate-700 mb-2">Suffix</label>
                <input type="text" name="suffix" id="suffix" placeholder="Jr., Sr., III (optional)" class="w-full bg-slate-50/50 border-0 rounded-2xl px-4 py-3 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email Address</label>
                <input type="email" name="email" id="email" placeholder="Email Address" class="w-full bg-slate-50/50 border-0 rounded-2xl px-4 py-3 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200" required>
            </div>
            <div>
                <label for="contact_number" class="block text-sm font-medium text-slate-700 mb-2">Contact Number</label>
                <input type="tel" name="contact_number" id="contact_number" placeholder="Contact Number" class="w-full bg-slate-50/50 border-0 rounded-2xl px-4 py-3 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200" required>
            </div>
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
            <div class="relative">
                <input type="password" name="password" id="password" placeholder="Password" class="w-full bg-slate-50/50 border-0 rounded-2xl px-4 py-3 pr-12 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200" required>
                <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-slate-400 hover:text-slate-600">
                    <i data-feather="eye" id="eyeIcon" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div>
                <label for="birthdate" class="block text-sm font-medium text-slate-700 mb-2">Birthdate</label>
                <input type="date" name="birthdate" id="birthdate" class="w-full bg-slate-50/50 border-0 rounded-2xl px-4 py-3 text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200" required>
            </div>
            <div>
                <label for="civil_status" class="block text-sm font-medium text-slate-700 mb-2">Civil Status</label>
                <select name="civil_status" id="civil_status" class="w-full bg-slate-50/50 border-0 rounded-2xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200" required>
                    <option value="">Select Civil Status</option>
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                    <option value="Divorced">Divorced</option>
                    <option value="Widowed">Widowed</option>
                </select>
            </div>
            <div>
                <label for="purok" class="block text-sm font-medium text-slate-700 mb-2">Purok</label>
                <select name="purok" id="purok" class="w-full bg-slate-50/50 border-0 rounded-2xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200" required>
                    <option value="">Select Purok</option>
                    <option value="Purok Mahigugma-on">Purok Mahigugma-on</option>
                    <option value="Purok Gumamela">Purok Gumamela</option>
                    <option value="Purok Santol">Purok Santol</option>
                    <option value="Purok Cebasca">Purok Cebasca</option>
                    <option value="Purok Fuente">Purok Fuente</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-4">
            <div>
                <label for="cash_assistance_programs" class="block text-sm font-medium text-slate-700 mb-2">Cash Assistance Programs</label>
                <select name="cash_assistance_programs" id="cash_assistance_programs" class="w-full bg-slate-50/50 border-0 rounded-2xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition-all duration-200" required>
                    <option value="">Select Cash Assistance Program</option>
                    <option value="Pantawid Pamilyang Pilipino Program (4Ps)">Pantawid Pamilyang Pilipino Program (4Ps)</option>
                    <option value="Assistance to Individuals in Crisis Situations (AICS)">Assistance to Individuals in Crisis Situations (AICS)</option>
                    <option value="Sustainable Livelihood Program (SLP)">Sustainable Livelihood Program (SLP)</option>
                    <option value="Targeted Cash Transfers (TCT)">Targeted Cash Transfers (TCT)</option>
                </select>
            </div>
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 text-base font-medium rounded-2xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            Create Account
        </button>
        
        <a href="{{ url('/') }}" class="w-full inline-block text-center bg-slate-100 text-slate-700 py-3 text-base font-medium rounded-2xl hover:bg-slate-200 transition-all duration-200">
            Back to Login
        </a>
    </form>

    <div class="text-center mt-6">
      <div class="pt-4 border-t border-slate-100">
        <p class="text-xs text-slate-400 mb-1">Powered by</p>
        <div class="text-xs text-slate-600 font-medium">Negros Oriental State University</div>
      </div>
    </div>

  </div>

  <script>
    // Clear all text inputs on page load
    window.addEventListener('load', function() {
        const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"], input[type="password"], input[type="date"], select, textarea');
        inputs.forEach(input => {
            input.value = '';
            if (input.tagName === 'SELECT') {
                input.selectedIndex = 0;
            }
        });
    });

    feather.replace();
    
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const eyeIcon = document.getElementById('eyeIcon');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.setAttribute('data-feather', 'eye-off');
      } else {
        passwordInput.type = 'password';
        eyeIcon.setAttribute('data-feather', 'eye');
      }
      feather.replace();
    }
  </script>
</body>
</html>
