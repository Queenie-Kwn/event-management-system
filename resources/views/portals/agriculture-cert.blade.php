@extends('home.admin')

@section('title', 'Agricultural Certification')

@section('content')

<!-- TOP BAR -->
<div class="w-[816px] mx-auto my-4 flex justify-between items-center">
    <div>
        <label class="block text-sm font-medium mb-1">Select Resident:</label>
        <input
            id="userInput"
            onchange="updateNameFromInput()"
            placeholder="Enter full name"
            class="border px-3 py-1 rounded w-64"
        >
    </div>

    <button
        onclick="window.print()"
        class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded text-sm font-semibold"
    >
        🖨 Print PDF
    </button>
</div>

<!-- BOND PAPER -->
<div class="bond-paper relative w-[816px] min-h-[1056px] mx-auto bg-white border border-black p-16">

    <!-- WATERMARK -->
    <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-20">
        <img src="{{ asset('images/barangay_logo.jpg') }}" class="w-[500px]" alt="Watermark">
    </div>

    <!-- HEADER -->
    <div class="relative text-center mb-8">
        <img src="{{ asset('images/barangay_logo.jpg') }}"
             class="w-24 h-24 mx-auto mb-2 object-contain">

        <p>Republic of the Philippines</p>
        <p>Province of Negros Oriental</p>
        <p>City of Dumaguete</p>

        <p class="font-bold mt-2">OFFICE OF THE BARANGAY CAPTAIN</p>
        <p class="font-bold">BARANGAY BAGACAY</p>

        <hr class="border-t border-dotted border-black mt-4">
    </div>

    <!-- TITLE -->
    <h2 class="text-center tracking-widest text-xl font-semibold mb-10">
        CERTIFICATION
    </h2>

    <!-- BODY -->
    <div class="relative text-[16px] leading-relaxed space-y-5">

        <p>
            This is to certify that
            <span id="certName" class="font-bold underline px-2">__________________</span>,
            of legal age, is a member of
            <span class="underline px-6">__________________</span>
            Association, a bonafide resident of Barangay Bagacay,
            Dumaguete City, Negros Oriental.
        </p>

        <p>This is to certify further that Mr./Mrs.
            <span class="underline px-6">__________________</span> is:
        </p>

        <p>_____ A certified farmer tilling an area of
            <span class="underline px-6">______</span>
            hectares located in
            <span class="underline px-6">____________</span> (barangay)
        </p>

        <p>_____ The area is planted with
            <span class="underline px-10">________________________</span>
            (name of crop/s)
        </p>

        <p>_____ The area is owned by
            <span class="underline px-16">________________________</span>
        </p>

        <p>_____ Raising livestock and poultry in his farm</p>

        <p>_____ He is a certified laborer/farm worker in the farm owned by
            <span class="underline px-10">________________________</span>
        </p>

        <p class="mt-6">
            This certification is issued upon the request of the above-named person
            in compliance with his/her application in Registry for Basic Sector in
            Agriculture (RSBSA).
        </p>

        <p>
            Given this
            <span id="day" class="underline px-3"></span>
            day of
            <span id="month" class="underline px-6"></span>,
            <span id="year" class="underline px-6"></span>
            at Barangay Bagacay, Dumaguete City.
        </p>

        <br><br>

        <!-- SIGNATURE -->
        <div class="text-center mt-10">
            <p class="font-bold uppercase">VINCENT ANDREW A. PERIGUA</p>
            <p>Barangay Captain</p>
        </div>
    </div>
</div>

<!-- SCRIPT -->
<script>
    function updateNameFromInput() {
        document.getElementById('certName').innerText =
            document.getElementById('userInput').value || '__________________';
    }

    const today = new Date();
    document.getElementById('day').innerText = today.getDate();
    document.getElementById('month').innerText =
        today.toLocaleString('default', { month: 'long' });
    document.getElementById('year').innerText = today.getFullYear();
</script>

<!-- PRINT -->
<style>
@media print {
    body {
        margin: 0;
    }

    body * {
        visibility: hidden;
        font-size: 22px;
    }

    .bond-paper, .bond-paper * {
        visibility: visible;
    }

    .bond-paper {
        font-size: 34px;
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        min-height: 100%;
        margin: 0;
        padding: 70px;
        border: none;
    }

    @page {
        size: letter;
        margin: 0;
    }
}

</style>

@endsection
