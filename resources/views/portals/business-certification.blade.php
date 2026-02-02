@extends('home.admin')

@section('title', 'Business Certification')

@section('content')

<!-- PRINT BUTTON -->
<div class="w-[816px] mx-auto my-4 text-right">
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
        BUSINESS CERTIFICATION
    </h2>

    <!-- BODY -->
    <div class="relative text-[16px] leading-relaxed space-y-5">

        <p class="font-semibold mb-4">TO WHOM IT MAY CONCERN:</p>

        <p>
            This is to certify that
            <input type="text" id="certName" class="font-bold underline px-2 bg-transparent border-none outline-none" value="JOGELEM L. INFANTE" placeholder="Full Name" style="width: auto;">,
            of legal age, married, and a resident of
            <input type="text" class="underline px-6 bg-transparent border-none outline-none" value="Purok Libra" placeholder="Purok/Address" style="width: auto;">,
            Barangay Bagacay, Dumaguete City, owned and managed
            <input type="text" class="underline px-6 bg-transparent border-none outline-none" value="Banana Que" placeholder="Business Name" style="width: auto;">
            business for
            <input type="text" class="underline px-3 bg-transparent border-none outline-none" value="2" placeholder="Years" style="width: auto;">
            years now.
        </p>

        <p>
            This certification is issued upon the request of the aforementioned for
            <input type="text" class="underline px-6 bg-transparent border-none outline-none" value="motor loan purposes" placeholder="Purpose" style="width: auto;">.
        </p>

        <p>
            Issued this
            <input type="text" id="day" class="underline px-3 bg-transparent border-none outline-none" value="25th" placeholder="Day" style="width: auto;">
            day of
            <input type="text" id="month" class="underline px-6 bg-transparent border-none outline-none" value="September" placeholder="Month" style="width: auto;">,
            <input type="text" id="year" class="underline px-6 bg-transparent border-none outline-none" value="2022" placeholder="Year" style="width: auto;">
            at the office of the Barangay Captain Barangay Bagacay, Dumaguete City.
        </p>

        <br><br><br>

        <!-- SIGNATURE -->
        <div class="text-center mt-16">
            <p class="font-bold uppercase">VINCENT ANDREW A. PERIGUA</p>
            <p>Punong Barangay</p>
        </div>
    </div>
</div>

<!-- SCRIPT -->
<script>
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