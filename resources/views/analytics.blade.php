<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics — BizzMap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styleanalytics.css') }}">
</head>
<body>
@include('partials.loading-screen')

@php
    $segMap = collect($segmentAnalytics ?? [])->keyBy('segment');

    $getCount = function(string $segment, string $field) use ($segMap) {
        $row = $segMap->get($segment);
        return (int) ($row->$field ?? 0);
    };

    $getExtra = function(string $segment) use ($segmentExtra) {
        return $segmentExtra[$segment] ?? [
            'non_customer_count' => 0,
            'potential_count'    => 0,
            'rekomendasi'        => 'Data belum tersedia.',
            'bulan_ini'          => 0,
            'bulan_lalu'         => 0,
            'selisih'            => 0,
        ];
    };
@endphp

{{-- HEADER GELAP --}}
<div class="ap-header">
    <div class="ap-header-left">
        <a href="javascript:history.back()" class="back-btn">
            <i class="fas fa-arrow-left"></i>
        </a>
        <span class="ap-title">Analytics</span>
    </div>
    <a href="{{ url('/menu') }}" class="home-btn">
        <i class="fas fa-home"></i> Home
    </a>
</div>

{{-- STATS STRIP --}}
<div class="stats-strip">
    <p class="stats-strip-title">Ringkasan data</p>
    <div class="stats-row">
        <div class="stat-item">
            <div class="stat-num">{{ $totalLokasi ?? 0 }}</div>
            <div class="stat-label">Total lokasi</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">{{ $customerTotal ?? 0 }}</div>
            <div class="stat-label">Customer</div>
        </div>
        <div class="stat-item accent">
            <div class="stat-num">{{ $nonCustomerTotal ?? 0 }}</div>
            <div class="stat-label">Non-customer</div>
        </div>
        <div class="stat-item">
            <div class="stat-num">{{ collect($segmentAnalytics ?? [])->count() }}</div>
            <div class="stat-label">Segmen aktif</div>
        </div>
    </div>
</div>

{{-- TOGGLE --}}
<div class="toggle-area">
    <div class="toggle-group">
        <button id="btn-customer" class="toggle-btn active">Customer</button>
        <button id="btn-non-customer" class="toggle-btn">Non-Customer</button>
    </div>
    <div class="toggle-label">
        <span class="toggle-dot"></span>
        Data real-time
    </div>
</div>

{{-- CONTENT --}}
<div class="content-area">

    <div id="empty-analytics-alert" class="d-none">
        <div class="fw-semibold">Belum ada data untuk dianalisis.</div>
        <div class="small">
            Jika data sudah di-approve tapi angka masih kosong, buka halaman <b>Map</b> terlebih dahulu
            agar data tersinkron ke perangkat (localStorage).
        </div>
    </div>

    {{-- CUSTOMER SEGMENT --}}
    <div id="customer-segment">
        <div class="section-label">Segmen Indibiz — Customer</div>
        <div class="card-grid">

            {{-- Ruko --}}
            <div class="seg-card">
                <div class="seg-card-top">
                    <div class="seg-icon"><i class="fas fa-store"></i></div>
                    <span class="seg-count-badge">{{ $getCount('ruko','customer') }} lokasi</span>
                </div>
                <p class="seg-name">Indibiz Ruko</p>
                <p class="seg-desc">Segmen pertokoan dan ruko</p>
                <div class="seg-rekomendasi" id="indibiz-ruko-message">Memuat rekomendasi...</div>
                <div class="seg-footer">
                    <a class="seg-download count-link"
                       data-count="{{ $getCount('ruko','customer') }}"
                       href="{{ route('analytics.download', ['type'=>'customer','segment'=>'ruko']) }}"
                       title="Download CSV">
                        <i class="fas fa-download"></i> Download CSV
                    </a>
                    <span class="seg-trend neutral">—</span>
                </div>
            </div>

            {{-- Sekolah --}}
            <div class="seg-card">
                <div class="seg-card-top">
                    <div class="seg-icon"><i class="fas fa-school"></i></div>
                    <span class="seg-count-badge">{{ $getCount('sekolah','customer') }} lokasi</span>
                </div>
                <p class="seg-name">Indibiz Sekolah</p>
                <p class="seg-desc">Segmen institusi pendidikan</p>
                <div class="seg-rekomendasi" id="indibiz-sekolah-message">Memuat rekomendasi...</div>
                <div class="seg-footer">
                    <a class="seg-download count-link"
                       data-count="{{ $getCount('sekolah','customer') }}"
                       href="{{ route('analytics.download', ['type'=>'customer','segment'=>'sekolah']) }}"
                       title="Download CSV">
                        <i class="fas fa-download"></i> Download CSV
                    </a>
                    <span class="seg-trend neutral">—</span>
                </div>
            </div>

            {{-- Hotel --}}
            <div class="seg-card">
                <div class="seg-card-top">
                    <div class="seg-icon"><i class="fas fa-hotel"></i></div>
                    <span class="seg-count-badge">{{ $getCount('hotel','customer') }} lokasi</span>
                </div>
                <p class="seg-name">Indibiz Hotel</p>
                <p class="seg-desc">Segmen perhotelan dan penginapan</p>
                <div class="seg-rekomendasi" id="indibiz-hotel-message">Memuat rekomendasi...</div>
                <div class="seg-footer">
                    <a class="seg-download count-link"
                       data-count="{{ $getCount('hotel','customer') }}"
                       href="{{ route('analytics.download', ['type'=>'customer','segment'=>'hotel']) }}"
                       title="Download CSV">
                        <i class="fas fa-download"></i> Download CSV
                    </a>
                    <span class="seg-trend neutral">—</span>
                </div>
            </div>

            {{-- MultiFinance --}}
            <div class="seg-card">
                <div class="seg-card-top">
                    <div class="seg-icon"><i class="fas fa-coins"></i></div>
                    <span class="seg-count-badge">{{ $getCount('multifinance','customer') }} lokasi</span>
                </div>
                <p class="seg-name">Indibiz MultiFinance</p>
                <p class="seg-desc">Segmen keuangan dan multifinance</p>
                <div class="seg-rekomendasi" id="indibiz-multifinance-message">Memuat rekomendasi...</div>
                <div class="seg-footer">
                    <a class="seg-download count-link"
                       data-count="{{ $getCount('multifinance','customer') }}"
                       href="{{ route('analytics.download', ['type'=>'customer','segment'=>'multifinance']) }}"
                       title="Download CSV">
                        <i class="fas fa-download"></i> Download CSV
                    </a>
                    <span class="seg-trend neutral">—</span>
                </div>
            </div>

            {{-- Health --}}
            <div class="seg-card">
                <div class="seg-card-top">
                    <div class="seg-icon"><i class="fas fa-heartbeat"></i></div>
                    <span class="seg-count-badge">{{ $getCount('health','customer') }} lokasi</span>
                </div>
                <p class="seg-name">Indibiz Health</p>
                <p class="seg-desc">Segmen layanan kesehatan</p>
                <div class="seg-rekomendasi" id="indibiz-health-message">Memuat rekomendasi...</div>
                <div class="seg-footer">
                    <a class="seg-download count-link"
                       data-count="{{ $getCount('health','customer') }}"
                       href="{{ route('analytics.download', ['type'=>'customer','segment'=>'health']) }}"
                       title="Download CSV">
                        <i class="fas fa-download"></i> Download CSV
                    </a>
                    <span class="seg-trend neutral">—</span>
                </div>
            </div>

            {{-- Ekspedisi --}}
            <div class="seg-card">
                <div class="seg-card-top">
                    <div class="seg-icon"><i class="fas fa-truck"></i></div>
                    <span class="seg-count-badge">{{ $getCount('ekspedisi','customer') }} lokasi</span>
                </div>
                <p class="seg-name">Indibiz Ekspedisi</p>
                <p class="seg-desc">Segmen logistik dan ekspedisi</p>
                <div class="seg-rekomendasi" id="indibiz-ekspedisi-message">Memuat rekomendasi...</div>
                <div class="seg-footer">
                    <a class="seg-download count-link"
                       data-count="{{ $getCount('ekspedisi','customer') }}"
                       href="{{ route('analytics.download', ['type'=>'customer','segment'=>'ekspedisi']) }}"
                       title="Download CSV">
                        <i class="fas fa-download"></i> Download CSV
                    </a>
                    <span class="seg-trend neutral">—</span>
                </div>
            </div>

            {{-- Energy --}}
            <div class="seg-card">
                <div class="seg-card-top">
                    <div class="seg-icon"><i class="fas fa-bolt"></i></div>
                    <span class="seg-count-badge">{{ $getCount('energi','customer') }} lokasi</span>
                </div>
                <p class="seg-name">Indibiz Energy</p>
                <p class="seg-desc">Segmen energi dan pertambangan</p>
                <div class="seg-rekomendasi" id="indibiz-energy-message">Memuat rekomendasi...</div>
                <div class="seg-footer">
                    <a class="seg-download count-link"
                       data-count="{{ $getCount('energi','customer') }}"
                       href="{{ route('analytics.download', ['type'=>'customer','segment'=>'energi']) }}"
                       title="Download CSV">
                        <i class="fas fa-download"></i> Download CSV
                    </a>
                    <span class="seg-trend neutral">—</span>
                </div>
            </div>

        </div>
    </div>{{-- /#customer-segment --}}

    {{-- NON-CUSTOMER SEGMENT --}}
    <div id="non-customer-segment" style="display:none;">
        <div class="section-label">Segmen Indibiz — Non-Customer</div>
        <div class="card-grid">

            {{-- Ruko --}}
            @php $extra = $getExtra('ruko'); @endphp
            <div class="seg-card">
                <div class="seg-card-top">
                    <div class="seg-icon"><i class="fas fa-store"></i></div>
                    <span class="seg-count-badge">{{ $getCount('ruko','non_customer') }} lokasi</span>
                </div>
                <p class="seg-name">Ruko</p>
                <p class="seg-desc">Segmen pertokoan dan ruko</p>
                <div class="seg-rekomendasi" id="ruko-message">
                    💡 <em>{{ $extra['rekomendasi'] }}</em>
                    @if($extra['potential_count'] > 0)
                        <br><small style="color:#92400E;">⭐ {{ $extra['potential_count'] }} dari {{ $extra['non_customer_count'] }} sudah ditandai potensial</small>
                    @endif
                </div>
                <div class="seg-footer">
                    <a class="seg-download count-link"
                       data-count="{{ $getCount('ruko','non_customer') }}"
                       href="{{ route('analytics.download', ['type'=>'non_customer','segment'=>'ruko']) }}"
                       title="Download CSV">
                        <i class="fas fa-download"></i> Download CSV
                    </a>
                    @if($extra['selisih'] > 0)
                        <span class="seg-trend">↑ +{{ $extra['selisih'] }}</span>
                    @elseif($extra['selisih'] < 0)
                        <span class="seg-trend down">↓ {{ $extra['selisih'] }}</span>
                    @else
                        <span class="seg-trend neutral">— Stabil</span>
                    @endif
                </div>
            </div>

            {{-- Sekolah --}}
            @php $extra = $getExtra('sekolah'); @endphp
            <div class="seg-card">
                <div class="seg-card-top">
                    <div class="seg-icon"><i class="fas fa-school"></i></div>
                    <span class="seg-count-badge">{{ $getCount('sekolah','non_customer') }} lokasi</span>
                </div>
                <p class="seg-name">Sekolah</p>
                <p class="seg-desc">Segmen institusi pendidikan</p>
                <div class="seg-rekomendasi" id="sekolah-message">
                    💡 <em>{{ $extra['rekomendasi'] }}</em>
                    @if($extra['potential_count'] > 0)
                        <br><small style="color:#92400E;">⭐ {{ $extra['potential_count'] }} dari {{ $extra['non_customer_count'] }} sudah ditandai potensial</small>
                    @endif
                </div>
                <div class="seg-footer">
                    <a class="seg-download count-link"
                       data-count="{{ $getCount('sekolah','non_customer') }}"
                       href="{{ route('analytics.download', ['type'=>'non_customer','segment'=>'sekolah']) }}"
                       title="Download CSV">
                        <i class="fas fa-download"></i> Download CSV
                    </a>
                    @if($extra['selisih'] > 0)
                        <span class="seg-trend">↑ +{{ $extra['selisih'] }}</span>
                    @elseif($extra['selisih'] < 0)
                        <span class="seg-trend down">↓ {{ $extra['selisih'] }}</span>
                    @else
                        <span class="seg-trend neutral">— Stabil</span>
                    @endif
                </div>
            </div>

            {{-- Hotel --}}
            @php $extra = $getExtra('hotel'); @endphp
            <div class="seg-card">
                <div class="seg-card-top">
                    <div class="seg-icon"><i class="fas fa-hotel"></i></div>
                    <span class="seg-count-badge">{{ $getCount('hotel','non_customer') }} lokasi</span>
                </div>
                <p class="seg-name">Hotel</p>
                <p class="seg-desc">Segmen perhotelan dan penginapan</p>
                <div class="seg-rekomendasi" id="hotel-message">
                    💡 <em>{{ $extra['rekomendasi'] }}</em>
                    @if($extra['potential_count'] > 0)
                        <br><small style="color:#92400E;">⭐ {{ $extra['potential_count'] }} dari {{ $extra['non_customer_count'] }} sudah ditandai potensial</small>
                    @endif
                </div>
                <div class="seg-footer">
                    <a class="seg-download count-link"
                       data-count="{{ $getCount('hotel','non_customer') }}"
                       href="{{ route('analytics.download', ['type'=>'non_customer','segment'=>'hotel']) }}"
                       title="Download CSV">
                        <i class="fas fa-download"></i> Download CSV
                    </a>
                    @if($extra['selisih'] > 0)
                        <span class="seg-trend">↑ +{{ $extra['selisih'] }}</span>
                    @elseif($extra['selisih'] < 0)
                        <span class="seg-trend down">↓ {{ $extra['selisih'] }}</span>
                    @else
                        <span class="seg-trend neutral">— Stabil</span>
                    @endif
                </div>
            </div>

            {{-- MultiFinance --}}
            @php $extra = $getExtra('multifinance'); @endphp
            <div class="seg-card">
                <div class="seg-card-top">
                    <div class="seg-icon"><i class="fas fa-coins"></i></div>
                    <span class="seg-count-badge">{{ $getCount('multifinance','non_customer') }} lokasi</span>
                </div>
                <p class="seg-name">MultiFinance</p>
                <p class="seg-desc">Segmen keuangan dan multifinance</p>
                <div class="seg-rekomendasi" id="multifinance-message">
                    💡 <em>{{ $extra['rekomendasi'] }}</em>
                    @if($extra['potential_count'] > 0)
                        <br><small style="color:#92400E;">⭐ {{ $extra['potential_count'] }} dari {{ $extra['non_customer_count'] }} sudah ditandai potensial</small>
                    @endif
                </div>
                <div class="seg-footer">
                    <a class="seg-download count-link"
                       data-count="{{ $getCount('multifinance','non_customer') }}"
                       href="{{ route('analytics.download', ['type'=>'non_customer','segment'=>'multifinance']) }}"
                       title="Download CSV">
                        <i class="fas fa-download"></i> Download CSV
                    </a>
                    @if($extra['selisih'] > 0)
                        <span class="seg-trend">↑ +{{ $extra['selisih'] }}</span>
                    @elseif($extra['selisih'] < 0)
                        <span class="seg-trend down">↓ {{ $extra['selisih'] }}</span>
                    @else
                        <span class="seg-trend neutral">— Stabil</span>
                    @endif
                </div>
            </div>

            {{-- Health --}}
            @php $extra = $getExtra('health'); @endphp
            <div class="seg-card">
                <div class="seg-card-top">
                    <div class="seg-icon"><i class="fas fa-heartbeat"></i></div>
                    <span class="seg-count-badge">{{ $getCount('health','non_customer') }} lokasi</span>
                </div>
                <p class="seg-name">Health</p>
                <p class="seg-desc">Segmen layanan kesehatan</p>
                <div class="seg-rekomendasi" id="health-message">
                    💡 <em>{{ $extra['rekomendasi'] }}</em>
                    @if($extra['potential_count'] > 0)
                        <br><small style="color:#92400E;">⭐ {{ $extra['potential_count'] }} dari {{ $extra['non_customer_count'] }} sudah ditandai potensial</small>
                    @endif
                </div>
                <div class="seg-footer">
                    <a class="seg-download count-link"
                       data-count="{{ $getCount('health','non_customer') }}"
                       href="{{ route('analytics.download', ['type'=>'non_customer','segment'=>'health']) }}"
                       title="Download CSV">
                        <i class="fas fa-download"></i> Download CSV
                    </a>
                    @if($extra['selisih'] > 0)
                        <span class="seg-trend">↑ +{{ $extra['selisih'] }}</span>
                    @elseif($extra['selisih'] < 0)
                        <span class="seg-trend down">↓ {{ $extra['selisih'] }}</span>
                    @else
                        <span class="seg-trend neutral">— Stabil</span>
                    @endif
                </div>
            </div>

            {{-- Ekspedisi --}}
            @php $extra = $getExtra('ekspedisi'); @endphp
            <div class="seg-card">
                <div class="seg-card-top">
                    <div class="seg-icon"><i class="fas fa-truck"></i></div>
                    <span class="seg-count-badge">{{ $getCount('ekspedisi','non_customer') }} lokasi</span>
                </div>
                <p class="seg-name">Ekspedisi</p>
                <p class="seg-desc">Segmen logistik dan ekspedisi</p>
                <div class="seg-rekomendasi" id="ekspedisi-message">
                    💡 <em>{{ $extra['rekomendasi'] }}</em>
                    @if($extra['potential_count'] > 0)
                        <br><small style="color:#92400E;">⭐ {{ $extra['potential_count'] }} dari {{ $extra['non_customer_count'] }} sudah ditandai potensial</small>
                    @endif
                </div>
                <div class="seg-footer">
                    <a class="seg-download count-link"
                       data-count="{{ $getCount('ekspedisi','non_customer') }}"
                       href="{{ route('analytics.download', ['type'=>'non_customer','segment'=>'ekspedisi']) }}"
                       title="Download CSV">
                        <i class="fas fa-download"></i> Download CSV
                    </a>
                    @if($extra['selisih'] > 0)
                        <span class="seg-trend">↑ +{{ $extra['selisih'] }}</span>
                    @elseif($extra['selisih'] < 0)
                        <span class="seg-trend down">↓ {{ $extra['selisih'] }}</span>
                    @else
                        <span class="seg-trend neutral">— Stabil</span>
                    @endif
                </div>
            </div>

            {{-- Energy --}}
            @php $extra = $getExtra('energi'); @endphp
            <div class="seg-card">
                <div class="seg-card-top">
                    <div class="seg-icon"><i class="fas fa-bolt"></i></div>
                    <span class="seg-count-badge">{{ $getCount('energi','non_customer') }} lokasi</span>
                </div>
                <p class="seg-name">Energy</p>
                <p class="seg-desc">Segmen energi dan pertambangan</p>
                <div class="seg-rekomendasi" id="energy-message">
                    💡 <em>{{ $extra['rekomendasi'] }}</em>
                    @if($extra['potential_count'] > 0)
                        <br><small style="color:#92400E;">⭐ {{ $extra['potential_count'] }} dari {{ $extra['non_customer_count'] }} sudah ditandai potensial</small>
                    @endif
                </div>
                <div class="seg-footer">
                    <a class="seg-download count-link"
                       data-count="{{ $getCount('energi','non_customer') }}"
                       href="{{ route('analytics.download', ['type'=>'non_customer','segment'=>'energi']) }}"
                       title="Download CSV">
                        <i class="fas fa-download"></i> Download CSV
                    </a>
                    @if($extra['selisih'] > 0)
                        <span class="seg-trend">↑ +{{ $extra['selisih'] }}</span>
                    @elseif($extra['selisih'] < 0)
                        <span class="seg-trend down">↓ {{ $extra['selisih'] }}</span>
                    @else
                        <span class="seg-trend neutral">— Stabil</span>
                    @endif
                </div>
            </div>

        </div>
    </div>{{-- /#non-customer-segment --}}

</div>{{-- /.content-area --}}

{{-- PAGE FOOTER --}}
<div class="page-footer">
    <span class="footer-info">BizzMap · PT Telkom Indonesia Branch Jambi</span>
    <span class="footer-badge">Indibiz Analytics</span>
</div>

<script>
function setCountClickable(el, clickable) {
    if (!el) return;
    el.style.textDecoration = clickable ? "underline" : "none";
    el.style.cursor = clickable ? "pointer" : "default";
}

const btnCustomer    = document.getElementById("btn-customer");
const btnNonCustomer = document.getElementById("btn-non-customer");
const customerSection    = document.getElementById("customer-segment");
const nonCustomerSection = document.getElementById("non-customer-segment");
const alertEl = document.getElementById("empty-analytics-alert");

function applyAnalyticsEmptyState() {
    let total = 0;

    document.querySelectorAll(".count-link").forEach((a) => {
        // Baca count dari data-count (format baru) atau textContent (fallback)
        const n = parseInt(a.dataset.count ?? a.textContent.trim(), 10) || 0;
        total += n;

        if (n === 0) {
            a.style.textDecoration = "none";
            a.style.cursor = "default";
            a.style.pointerEvents = "none";
            a.classList.add("text-muted");
            a.setAttribute("aria-disabled", "true");
            a.setAttribute("tabindex", "-1");
        } else {
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

applyAnalyticsEmptyState();

btnCustomer.addEventListener('click', function() {
    customerSection.style.display = 'block';
    nonCustomerSection.style.display = 'none';
    btnCustomer.classList.add('active');
    btnNonCustomer.classList.remove('active');
});

btnNonCustomer.addEventListener('click', function() {
    nonCustomerSection.style.display = 'block';
    customerSection.style.display = 'none';
    btnNonCustomer.classList.add('active');
    btnCustomer.classList.remove('active');
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
