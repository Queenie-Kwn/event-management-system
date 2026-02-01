@extends('home.admin')

@section('title', 'Dashboard')

@section('content')

<style>
    /* SCREEN STYLES */
    .top-bar {
        width: 816px;
        margin: 10px auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .bond-paper {
        width: 816px;
        min-height: 1056px;
        margin: 0 auto;
        padding: 60px;
        border: 1px solid #000;
        background: #fff;
        font-family: Arial;
        color: #000;
        font-size: 16px;
    }

    .bond-paper {
        position: relative;
    }

    .watermark {
        position: absolute;
        top: 60%;
        left: 50%;
        transform: translate(-50%, -50%);
        opacity: 0.2;
        z-index: 0;
        pointer-events: none;
    }

    .watermark img {
        width: 1000px;
        height: auto;
    }

    .header {
        text-align: center;
        margin-bottom: 40px;
    }

    .logo {
        width: 90px;
        height: 90px;
        margin: 0 auto 10px;
    }

    .content-text {
        line-height: 2;
        text-align: justify;
    }

    .underline {
        font-weight: bold;
        text-decoration: underline;
    }

    /* PRINT STYLES */
    @media print {
        body * {
            visibility: hidden;
        }

        .bond-paper, .bond-paper * {
            visibility: visible;
        }

        .bond-paper {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            margin: 0;
            padding: 70px;
            border: none;
            font-size: 20px;
        }

        .header h3,
        .header h4 {
            font-size: 30px;
        }

        .content-text {
            font-size: 26px;
            line-height: 2;
        }

        @page {
            size: letter;
            margin: 0;
        }
         .logo img {
            width: 240px !important;
            height: 240px !important;
        }
    }
</style>

<!-- TOP BAR -->
<div class="top-bar">
    
    <div>
        <label>Select Resident:</label>

        <input
            list="residentList"
            id="residentInput"
            placeholder="Search or select resident"
            onchange="updateResidentFromInput()"
            class="border px-1 py-1 rounded w-44"
        />

        <datalist id="residentList">
            @foreach ($residents as $resident)
                <option
                    value="{{ $resident->name }}"
                    data-purok="{{ $resident->purok }}">
                </option>
            @endforeach
        </datalist>

        <label class="ml-4">Purpose:</label>

        <input
            list="purposeList"
            id="purposeInput"
            placeholder="Select or type purpose"
            onchange="updatePurpose()"
            class="border px-2 py-1 rounded w-44"
        />

        <datalist id="purposeList">
            <option value="financial assistance">
            <option value="medical assistance">
            <option value="educational assistance">
            <option value="scholarship application">
            <option value="employment requirement">
            <option value="DSWD requirement">
            <option value="PhilHealth requirement">
            <option value="burial assistance">
            <option value="loan application">
        </datalist>

        <button
            type="button"
            onclick="clearCertificate()"
            class="ml-2 bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm"
        >
            Clear
        </button>

    </div>

    <button
        onclick="window.print()"
        class="flex items-center gap-2 bg-gray-800 hover:bg-gray-900 text-white text-sm font-semibold px-4 py-2 rounded-md shadow-md transition"
    >
        🖨 Print PDF
    </button>
</div>

<!-- BOND PAPER -->
    <div class="bond-paper">

        <div class="watermark">
            <img src="{{ asset('images/barangay_logo.jpg') }}" alt="Watermark Logo">
        </div>

        <!-- HEADER -->
        <div class="header" style="display:flex; align-items:center; gap:20px;">

        <!-- LOGO (LEFT) -->
        <div class="logo" style="width:150px; height:150px;">
            <img src="{{ asset('images/barangay_logo.jpg') }}"
                alt="Barangay Logo"
                style="width:140px; height:140px; object-fit:contain;">
        </div>

        <!-- TEXT (RIGHT) -->
        <div style="text-align:left; flex:1;">
            <div style="text-align:center;">
                <p style="margin:0;">Republic of the Philippines</p>
                <p style="margin:0;">Province of Negros Oriental</p>
                <p style="margin:0;">City of Dumaguete</p>

                <br>

                <p style="margin:0; font-weight:bold;">BARANGAY BAGACAY</p>
                <p style="margin:0; font-weight:bold;">OFFICE OF THE BARANGAY CAPTAIN</p>
            </div>
        </div>

    </div>

    <br>

    <h3 style="text-align:center; font-size: 36px"><u>CERTIFICATE OF INDIGENCY</u></h3>
    <br>


    <!-- BODY -->
    <div class="content-text">

        <p><strong>TO WHOM IT MAY CONCERN:</strong></p>

        <span id="certName" class="underline">__________________</span>,
        of legal age, single/married, is a resident of
        Purok <span id="certPurok" class="underline">__________________</span>,

        <p>
            Furthermore he/she belongs to the indigent families of this barangay
            whose family income falls below poverty line.
        </p>

        <p>
            This certification is issued upon the request of the aforementioned for
            <span id="certPurpose" class="underline">_______________________________</span>.
        </p>

        <p>
            Issued this
            <span class="underline" id="day"></span>
            day of
            <span class="underline" id="month"></span>,
            <span class="underline" id="year"></span>
            at the office of the Barangay Captain Barangay Bagacay,
            Dumaguete City, Philippines.
        </p>

        <br><br><br>

        <p style="text-align:center;">
            <strong>VINCENT ANDREW A. PERIGUA</strong><br>
            Barangay Chairman
        </p>

    </div>

</div>

<script>
    function clearCertificate() {
        // Clear inputs
        document.getElementById('residentInput').value = '';
        document.getElementById('purposeInput').value = '';

        // Reset certificate text
        document.getElementById('certName').innerText = '__________________';
        document.getElementById('certPurok').innerText = '__________________';
        document.getElementById('certPurpose').innerText = '_______________________________';
    }
</script>

<script>
    function updatePurpose() {
        const purpose = document.getElementById('purposeInput').value;
        document.getElementById('certPurpose').innerText =
            purpose || '_______________________________';
    }
</script>

<script>
    function updateResidentFromInput() {
        const input = document.getElementById('residentInput').value;
        const options = document.querySelectorAll('#residentList option');

        let purok = '__________________';

        options.forEach(option => {
            if (option.value === input) {
                purok = option.dataset.purok;
            }
        });

        document.getElementById('certName').innerText = input || '__________________';
        document.getElementById('certPurok').innerText = purok;
    }

    // DATE
    const today = new Date();
    document.getElementById('day').innerText = today.getDate();
    document.getElementById('month').innerText =
        today.toLocaleString('default', { month: 'long' });
    document.getElementById('year').innerText = today.getFullYear();
</script>

<script>
    function updateNameFromInput() {
        document.getElementById('certName').innerText =
            document.getElementById('userInput').value;
    }
</script>


@endsection
