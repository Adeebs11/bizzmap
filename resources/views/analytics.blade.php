<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytic Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styleanalytics.css') }}">

</head>
<body>
    @php
        $segMap = collect($segmentAnalytics ?? [])->keyBy('segment');

        $getCount = function(string $segment, string $field) use ($segMap) {
            $row = $segMap->get($segment);
            return (int) ($row->$field ?? 0);
        };
    @endphp

    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-4">
            <a href="javascript:history.back()" class="btn btn-light">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <h1 class="text-center mb-0 flex-grow-1">Analytic</h1>
            <a href="{{ url('/menu') }}" class="btn btn-light">
                <i class="fas fa-home"></i> Home
            </a>
        </div>

        <!-- Switch between Customer and Non-Customer -->
        <div class="d-flex justify-content-center mb-4">
            <button id="btn-customer" class="btn btn-primary me-2">Customer</button>
            <button id="btn-non-customer" class="btn btn-secondary">Non-Customer</button>
        </div>

        <div id="empty-analytics-alert" class="alert alert-info d-none">
        <div class="fw-semibold">Belum ada data untuk dianalisis.</div>
        <div class="small">
            Jika data sudah di-approve tapi angka masih kosong, buka halaman <b>Map</b> terlebih dahulu
            agar data tersinkron ke perangkat (localStorage).
        </div>
        </div>

        <div id="customer-segment" class="row">
            <!-- Indibiz Segments -->
            <div class="col-md-6 mb-4">
                <div class="summary-box">
                    <i class="fa-solid fa-building summary-icon"></i>
                    <h2>Indibiz Ruko</h2>
                        <p>
                        Berdasarkan data demografi, jumlah pengguna pada segmen Indibiz Ruko adalah sebanyak
                        <a class="highlighted-count count-link"
                            href="{{ route('analytics.download', ['type' => 'customer', 'segment' => 'ruko']) }}"
                            title="Download CSV (Customer - Ruko)">
                            {{ $getCount('ruko','customer') }}
                        </a>
                        </p>
                    <p id="indibiz-ruko-message"></p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="summary-box">
                    <i class="fa-solid fa-school summary-icon"></i>
                    <h2>Indibiz Sekolah</h2>
                    <p>Berdasarkan data demografi, jumlah pengguna pada segmen Indibiz Sekolah adalah sebanyak 
                        <a class="highlighted-count count-link"
                            href="{{ route('analytics.download', ['type' => 'customer', 'segment' => 'sekolah']) }}"
                            title="Download CSV (Customer - Sekolah)">
                            {{ $getCount('sekolah', 'customer') }}
                        </a>
                    </p>
                    <p id="indibiz-sekolah-message"></p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="summary-box">
                    <i class="fa-solid fa-hotel summary-icon"></i>
                    <h2>Indibiz Hotel</h2>
                    <p>Berdasarkan data demografi, jumlah pengguna pada segmen Indibiz Hotel adalah sebanyak 
                        <a class="highlighted-count count-link"
                            href="{{ route('analytics.download', ['type' => 'customer', 'segment' => 'hotel']) }}"
                            title="Download CSV (Customer - Hotel)">
                            {{ $getCount('hotel', 'customer') }}
                        </a>
                    </p>
                    <p id="indibiz-hotel-message"></p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="summary-box">
                    <i class="fa-solid fa-money-bill summary-icon"></i>
                    <h2>Indibiz MultiFinance</h2>
                    <p>Berdasarkan data demografi, jumlah pengguna pada segmen Indibiz MultiFinance adalah sebanyak 
                        <a class="highlighted-count count-link"
                            href="{{ route('analytics.download', ['type' => 'customer', 'segment' => 'multifinance']) }}"
                            title="Download CSV (Customer - MultiFinance)">
                            {{ $getCount('multifinance', 'customer') }}
                        </a>
                    </p>
                    <p id="indibiz-multifinance-message"></p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="summary-box">
                    <i class="fa-solid fa-house-medical summary-icon"></i>
                    <h2>Indibiz Health</h2>
                    <p>Berdasarkan data demografi, jumlah pengguna pada segmen Indibiz Health adalah sebanyak 
                        <a class="highlighted-count count-link"
                            href="{{ route('analytics.download', ['type' => 'customer', 'segment' => 'health']) }}"
                            title="Download CSV (Customer - Health)">
                            {{ $getCount('health', 'customer') }}
                        </a>
                    </p>
                    <p id="indibiz-health-message"></p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="summary-box">
                    <i class="fa-solid fa-truck summary-icon"></i>
                    <h2>Indibiz Ekspedisi</h2>
                    <p>Berdasarkan data demografi, jumlah pengguna pada segmen Indibiz Ekspedisi adalah sebanyak 
                        <a class="highlighted-count count-link"
                            href="{{ route('analytics.download', ['type' => 'customer', 'segment' => 'ekspedisi']) }}"
                            title="Download CSV (Customer - Ekspedisi)">
                            {{ $getCount('ekspedisi', 'customer') }}
                        </a>
                    </p>
                    <p id="indibiz-ekspedisi-message"></p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="summary-box">
                    <i class="fa-solid fa-bolt summary-icon"></i>
                    <h2>Indibiz Energy</h2>
                    <p>Berdasarkan data demografi, jumlah pengguna pada segmen Indibiz Energy adalah sebanyak 
                        <a class="highlighted-count count-link"
                            href="{{ route('analytics.download', ['type' => 'customer', 'segment' => 'energi']) }}"
                            title="Download CSV (Customer - Energy)">
                            {{ $getCount('energi', 'customer') }}
                        </a>
                    </p>
                    <p id="indibiz-energy-message"></p>
                </div>
            </div>
        </div>

        <div id="non-customer-segment" class="row" style="display: none;">
            <!-- Non-Customer Segments -->
            <div class="col-md-6 mb-4">
                <div class="summary-box">
                    <i class="fa-solid fa-building summary-icon"></i>
                    <h2>Ruko</h2>
                    <p>Berdasarkan data demografi, jumlah pengguna pada segmen Ruko adalah sebanyak 
                        <a class="highlighted-count count-link"
                            href="{{ route('analytics.download', ['type' => 'non_customer', 'segment' => 'ruko']) }}"
                            title="Download CSV (Non-Customer - Ruko)">
                            {{ $getCount('ruko', 'non_customer') }}
                        </a>
                    </p>
                    <p id="ruko-message"></p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="summary-box">
                    <i class="fa-solid fa-school summary-icon"></i>
                    <h2>Sekolah</h2>
                    <p>Berdasarkan data demografi, jumlah pengguna pada segmen Sekolah adalah sebanyak 
                        <a class="highlighted-count count-link"
                            href="{{ route('analytics.download', ['type' => 'non_customer', 'segment' => 'sekolah']) }}"
                            title="Download CSV (Non-Customer - Sekolah)">
                            {{ $getCount('sekolah', 'non_customer') }}
                        </a>
                    </p>
                    <p id="sekolah-message"></p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="summary-box">
                    <i class="fa-solid fa-hotel summary-icon"></i>
                    <h2>Hotel</h2>
                    <p>Berdasarkan data demografi, jumlah pengguna pada segmen Hotel adalah sebanyak 
                        <a class="highlighted-count count-link"
                            href="{{ route('analytics.download', ['type' => 'non_customer', 'segment' => 'hotel']) }}"
                            title="Download CSV (Non-Customer - Hotel)">
                            {{ $getCount('hotel', 'non_customer') }}
                        </a>
                    </p>
                    <p id="hotel-message"></p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="summary-box">
                    <i class="fa-solid fa-money-bill summary-icon"></i>
                    <h2>MultiFinance</h2>
                    <p>Berdasarkan data demografi, jumlah pengguna pada segmen MultiFinance adalah sebanyak 
                        <a class="highlighted-count count-link"
                            href="{{ route('analytics.download', ['type' => 'non_customer', 'segment' => 'multifinance']) }}"
                            title="Download CSV (Non-Customer - MultiFinance)">
                            {{ $getCount('multifinance', 'non_customer') }}
                        </a>
                    </p>
                    <p id="multifinance-message"></p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="summary-box">
                    <i class="fa-solid fa-house-medical summary-icon"></i>
                    <h2>Health</h2>
                    <p>Berdasarkan data demografi, jumlah pengguna pada segmen Health adalah sebanyak 
                        <a class="highlighted-count count-link"
                            href="{{ route('analytics.download', ['type' => 'non_customer', 'segment' => 'health']) }}"
                            title="Download CSV (Non-Customer - Health)">
                            {{ $getCount('health', 'non_customer') }}
                        </a>
                    </p>
                    <p id="health-message"></p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="summary-box">
                    <i class="fa-solid fa-truck summary-icon"></i>
                    <h2>Ekspedisi</h2>
                    <p>Berdasarkan data demografi, jumlah pengguna pada segmen Ekspedisi adalah sebanyak 
                        <a class="highlighted-count count-link"
                            href="{{ route('analytics.download', ['type' => 'non_customer', 'segment' => 'ekspedisi']) }}"
                            title="Download CSV (Non-Customer - Ekspedisi)">
                            {{ $getCount('ekspedisi', 'non_customer') }}
                        </a>
                    </p>
                    <p id="ekspedisi-message"></p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="summary-box">
                    <i class="fa-solid fa-bolt summary-icon"></i>
                    <h2>Energy</h2>
                    <p>Berdasarkan data demografi, jumlah pengguna pada segmen Energy adalah sebanyak 
                        <a class="highlighted-count count-link"
                            href="{{ route('analytics.download', ['type' => 'non_customer', 'segment' => 'energi']) }}"
                            title="Download CSV (Non-Customer - Energy)">
                            {{ $getCount('energi', 'non_customer') }}
                        </a>
                    </p>
                    <p id="energy-message"></p>
                </div>
            </div>
        </div>
    </div>

    <script>
    function setCountClickable(el, clickable) {
    if (!el) return;
    el.style.textDecoration = clickable ? "underline" : "none";
    el.style.cursor = clickable ? "pointer" : "default";
    }

    // ambil elemen tombol & section (ID harus sama dengan HTML)
const btnCustomer = document.getElementById("btn-customer");
const btnNonCustomer = document.getElementById("btn-non-customer");
const customerSection = document.getElementById("customer-segment");
const nonCustomerSection = document.getElementById("non-customer-segment");

const alertEl = document.getElementById("empty-analytics-alert");

// disable link download kalau count = 0, dan tampilkan alert kalau total = 0
function applyAnalyticsEmptyState() {
    let total = 0;

    document.querySelectorAll(".count-link").forEach((a) => {
        const n = parseInt(a.textContent.trim(), 10) || 0;
        total += n;

        if (n === 0) {
            // non-aktifkan link (tidak bisa diklik)
            a.style.textDecoration = "none";
            a.style.cursor = "default";
            a.style.pointerEvents = "none";
            a.classList.add("text-muted");
            a.setAttribute("aria-disabled", "true");
            a.setAttribute("tabindex", "-1");
        } else {
            // pastikan link aktif
            a.style.textDecoration = "underline";
            a.style.cursor = "pointer";
            a.style.pointerEvents = "auto";
            a.classList.remove("text-muted");
            a.removeAttribute("aria-disabled");
            a.removeAttribute("tabindex");
        }
    });

    if (total === 0) {
        alertEl?.classList.remove("d-none");
    } else {
        alertEl?.classList.add("d-none");
    }
}

// jalankan saat halaman dibuka
applyAnalyticsEmptyState();

    btnCustomer.addEventListener('click', function() {
        customerSection.style.display = 'flex';
        customerSection.style.flexWrap = 'wrap';
        nonCustomerSection.style.display = 'none';

        btnCustomer.classList.add('btn-primary');
        btnCustomer.classList.remove('btn-secondary');
        btnNonCustomer.classList.add('btn-secondary');
        btnNonCustomer.classList.remove('btn-primary');
    });

    btnNonCustomer.addEventListener('click', function() {
        nonCustomerSection.style.display = 'flex';
        nonCustomerSection.style.flexWrap = 'wrap';
        customerSection.style.display = 'none';

        btnNonCustomer.classList.add('btn-primary');
        btnNonCustomer.classList.remove('btn-secondary');
        btnCustomer.classList.add('btn-secondary');
        btnCustomer.classList.remove('btn-primary');
    });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
