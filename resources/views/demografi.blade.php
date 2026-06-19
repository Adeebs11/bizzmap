<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demografi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styledemografi.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .carousel-indicators button.active {
            opacity: 1 !important;
        }
    </style>

</head>
<body>
    <div class="d-flex">
        <div class="sidebar">
            <h2>Menu</h2>
            <ul>
                <li><a href="{{ url("/menu") }}"><i class="fas fa-home"></i> <span>Home</span></a></li>
                <li><a href="{{ url("/geo") }}"><i class="fas fa-map-marker-alt"></i> <span>Map</span></a></li>
                <li><a href="{{ url("/analytics") }}"><i class="fas fa-chart-pie"></i> <span>Analytic</span></a></li>
            </ul>
        </div>
        <div class="container mt-5" id="main-content">
            <div class="d-flex justify-content-between mb-4">
                <a href="javascript:history.back()" class="btn btn-light">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
            <h1 class="text-center mb-5">DEMOGRAFI</h1>

            @php
            $totalAll = (int)$customerTotal + (int)$nonCustomerTotal;
            @endphp

            @if($totalAll === 0)
            <div class="alert alert-info">
                <div class="fw-semibold">Data demografi belum tersedia.</div>
                <div class="small">
                Belum ada data lokasi yang berstatus <b>approved</b>.
                Silakan input data melalui halaman Peta, lalu tunggu verifikasi admin.
                </div>
            </div>
            @endif

            {{-- 4 Kartu Statistik --}}
            <div class="row g-3 mb-4">
              @php
                $statCards = [
                    ['icon'=>'fa-map-marker-alt','label'=>'Total Lokasi',
                     'value'=>$totalLokasi,'color'=>'#3B82F6','bg'=>'#EFF6FF'],
                    ['icon'=>'fa-user-check','label'=>'Customer',
                     'value'=>$customerTotal,'color'=>'#10B981','bg'=>'#ECFDF5'],
                    ['icon'=>'fa-user-times','label'=>'Non-Customer',
                     'value'=>$nonCustomerTotal,'color'=>'#C02016','bg'=>'#FEF2F2'],
                    ['icon'=>'fa-clock','label'=>'Pending Verifikasi',
                     'value'=>$totalPending,'color'=>'#F59E0B','bg'=>'#FFFBEB'],
                ];
              @endphp
              @foreach($statCards as $card)
              <div class="col-6 col-md-3">
                <div style="background:{{ $card['bg'] }};border-radius:12px;
                            padding:18px;position:relative;overflow:hidden;
                            box-shadow:0 2px 8px rgba(0,0,0,0.06);
                            transition:transform 0.2s;"
                     onmouseover="this.style.transform='translateY(-3px)'"
                     onmouseout="this.style.transform='translateY(0)'">
                  <i class="fas {{ $card['icon'] }}"
                     style="position:absolute;right:10px;top:10px;
                            font-size:32px;color:{{ $card['color'] }};
                            opacity:0.12;"></i>
                  <div style="font-size:26px;font-weight:700;
                              color:{{ $card['color'] }};">
                    {{ $card['value'] }}
                  </div>
                  <div style="font-size:12px;color:#555;margin-top:3px;
                              font-weight:500;">
                    {{ $card['label'] }}
                  </div>
                </div>
              </div>
              @endforeach
            </div>

            <div class="row text-center mb-4">
                {{-- Wrapper agar ada jarak dari info box atas --}}
                <div class="segment-badge-wrapper">
                    <div class="row g-3">

                        {{-- Segmen Customer Dominan --}}
                        <div class="col-md-6">
                            <div class="alert segment-alert segment-customer">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-briefcase-fill segment-icon me-2"></i>
                                        <strong>Segmen Customer Dominan</strong>
                                    </div>
                                    <span class="badge segment-badge text-uppercase">
                                        {{ $dominantCustomerSegment ?? '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Segmen Non-Customer Dominan --}}
                        <div class="col-md-6">
                            <div class="alert segment-alert segment-noncustomer">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-exclamation-circle-fill segment-icon me-2"></i>
                                        <strong>Segmen Non-Customer Dominan</strong>
                                    </div>
                                    <span class="badge segment-badge text-uppercase">
                                        {{ $dominantNonCustomerSegment ?? '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

        @if($totalAll > 0)
            <div class="row gx-3 gy-2 mb-3">
                <div class="col-lg-8 mx-auto">
                    <div class="chart-card" style="height:auto;min-height:400px;position:relative;padding:16px 16px 12px;">

                        <div id="chartCarousel" class="carousel slide" data-bs-ride="false">
                            <div class="carousel-inner" style="height:320px;">

                                <div class="carousel-item active">
                                    <h6 style="text-align:center;font-weight:600;color:#333;margin-bottom:8px;">
                                        Customer vs Non-Customer
                                    </h6>
                                    <div style="position:relative;height:280px;">
                                        <canvas id="businessTypeChart"></canvas>
                                    </div>
                                </div>

                                <div class="carousel-item">
                                    <h6 style="text-align:center;font-weight:600;color:#333;margin-bottom:8px;">
                                        Distribusi Segmen Customer
                                    </h6>
                                    <div style="position:relative;height:280px;">
                                        <canvas id="segmentCustomerChart"></canvas>
                                    </div>
                                </div>

                                <div class="carousel-item">
                                    <h6 style="text-align:center;font-weight:600;color:#333;margin-bottom:8px;">
                                        Distribusi Segmen Non-Customer
                                    </h6>
                                    <div style="position:relative;height:280px;">
                                        <canvas id="segmentNonCustomerChart"></canvas>
                                    </div>
                                </div>

                            </div>

                            <button class="carousel-control-prev" type="button"
                                    data-bs-target="#chartCarousel" data-bs-slide="prev"
                                    style="width:36px;height:36px;top:50%;transform:translateY(-50%);
                                           background:rgba(192,32,22,0.7);border-radius:50%;left:-5px;">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button"
                                    data-bs-target="#chartCarousel" data-bs-slide="next"
                                    style="width:36px;height:36px;top:50%;transform:translateY(-50%);
                                           background:rgba(192,32,22,0.7);border-radius:50%;right:-5px;">
                                <span class="carousel-control-next-icon"></span>
                            </button>

                            <div class="carousel-indicators"
                                 style="position:relative;bottom:0;margin:8px 0 0;
                                        display:flex;justify-content:center;gap:6px;">
                                <button type="button" data-bs-target="#chartCarousel"
                                        data-bs-slide-to="0" class="active" aria-current="true"
                                        style="width:8px !important;height:8px !important;
                                               border-radius:50% !important;
                                               background-color:#C02016 !important;
                                               border:none !important;
                                               opacity:0.4;text-indent:-9999px;
                                               padding:0;margin:0;"></button>
                                <button type="button" data-bs-target="#chartCarousel"
                                        data-bs-slide-to="1"
                                        style="width:8px !important;height:8px !important;
                                               border-radius:50% !important;
                                               background-color:#C02016 !important;
                                               border:none !important;
                                               opacity:0.4;text-indent:-9999px;
                                               padding:0;margin:0;"></button>
                                <button type="button" data-bs-target="#chartCarousel"
                                        data-bs-slide-to="2"
                                        style="width:8px !important;height:8px !important;
                                               border-radius:50% !important;
                                               background-color:#C02016 !important;
                                               border:none !important;
                                               opacity:0.4;text-indent:-9999px;
                                               padding:0;margin:0;"></button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- P3B: Analisis Detail — Omset, Paket, Bidang Bisnis --}}
            <div style="margin-top:28px;">
                <h6 style="font-weight:700;color:#111;margin-bottom:16px;
                           border-left:3px solid #C02016;padding-left:10px;">
                    Analisis Detail
                </h6>
                <div class="row g-3">
                    {{-- Chart Omset: full width grouped bar --}}
                    <div class="col-12">
                        <div class="chart-card" style="height:auto;min-height:320px;padding:20px;">
                            <h6 style="font-weight:600;color:#333;margin-bottom:4px;">&#x1F4B0; Distribusi Omset</h6>
                            <p style="font-size:12px;color:#888;margin:0 0 8px;">Perbandingan range omset antara Customer dan Non-Customer</p>
                            <div style="position:relative;height:240px;max-width:600px;margin:0 auto;">
                                <canvas id="chartOmset"></canvas>
                            </div>
                        </div>
                    </div>
                    {{-- Chart Paket: doughnut --}}
                    <div class="col-md-6">
                        <div class="chart-card" style="height:auto;min-height:340px;padding:20px;">
                            <h6 style="font-weight:600;color:#333;margin-bottom:4px;">&#x1F4E6; Top 5 Paket Langganan</h6>
                            <p style="font-size:12px;color:#888;margin:0 0 8px;">Paket Indibiz yang paling banyak digunakan Customer</p>
                            @if($byPaket->count() > 0)
                                <div style="position:relative;height:220px;max-width:280px;margin:0 auto;">
                                    <canvas id="chartPaket"></canvas>
                                </div>
                            @else
                                <div style="text-align:center;padding:30px 0;color:#9CA3AF;">
                                    <div style="font-size:28px;">&#x1F4E6;</div>
                                    <div style="font-size:12px;margin-top:6px;">Belum ada data paket langganan</div>
                                </div>
                            @endif
                        </div>
                    </div>
                    {{-- Chart Bidang Bisnis: vertical bar --}}
                    <div class="col-md-6">
                        <div class="chart-card" style="height:auto;min-height:340px;padding:20px;">
                            <h6 style="font-weight:600;color:#333;margin-bottom:4px;">&#x1F3E2; Top 5 Bidang Bisnis</h6>
                            <p style="font-size:12px;color:#888;margin:0 0 8px;">Jenis usaha yang paling banyak tercatat di sistem</p>
                            @if($byBidang->count() > 0)
                                <div style="position:relative;height:220px;max-width:320px;margin:0 auto;">
                                    <canvas id="chartBidang"></canvas>
                                </div>
                            @else
                                <div style="text-align:center;padding:30px 0;color:#9CA3AF;">
                                    <div style="font-size:28px;">&#x1F3E2;</div>
                                    <div style="font-size:12px;margin-top:6px;">Belum ada data bidang bisnis</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div style="background:#F8F9FA;border-radius:10px;padding:12px 16px;margin-top:16px;display:flex;align-items:center;flex-wrap:wrap;gap:10px;">
                    <span style="font-size:12px;color:#666;">&#x1F4A1; Data hanya menghitung lokasi yang sudah di-approve dan memiliki nilai omset / paket / bidang bisnis terisi.</span>
                </div>
            </div>

            {{-- Chart Tren Konversi (selalu render, data bisa kosong) --}}
            <div class="row gx-3 gy-2 mt-3">
              <div class="col-12">
                <div style="background:white;border-radius:12px;
                            padding:22px;box-shadow:0 2px 12px rgba(0,0,0,0.07);">
                  <div style="display:flex;justify-content:space-between;
                              align-items:center;margin-bottom:14px;
                              flex-wrap:wrap;gap:8px;">
                    <div>
                      <h6 style="font-weight:700;color:#111;margin:0;">
                        📈 Tren Konversi &amp; Churn
                      </h6>
                      <p style="font-size:12px;color:#888;margin:2px 0 0;">
                        Konversi (Non→Customer) vs Churn (Customer→Non) per periode
                      </p>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                      <select id="periodeSelector" onchange="updateTrenChart()"
                              style="font-size:12px;padding:4px 10px;border-radius:8px;
                                     border:1px solid #D1D5DB;background:white;cursor:pointer;
                                     color:#374151;font-family:inherit;">
                        <option value="weekly">1 Minggu</option>
                        <option value="monthly">1 Bulan</option>
                        <option value="sixmonth" selected>6 Bulan</option>
                      </select>
                      <div id="trenBadge" style="font-size:12px;font-weight:600;
                           padding:4px 12px;border-radius:20px;"></div>
                    </div>
                  </div>

                  @if($statusChanges->every(fn($m) => $m['konversi'] === 0 && $m['churn'] === 0))
                  <p style="font-size:12px;color:#9CA3AF;text-align:center;margin-bottom:8px;">
                    ℹ️ Belum ada data konversi maupun churn. Riwayat akan muncul setelah ada perubahan tipe lokasi.
                  </p>
                  @endif

                  <canvas id="chartTren" height="90"></canvas>

                  <div class="row g-3 mt-3">
                    <div class="col-6 col-md-3">
                      <div style="background:#ECFDF5;border-radius:10px;
                                  padding:14px;text-align:center;">
                        <div style="font-size:22px;font-weight:700;color:#10B981;">
                          {{ $konversiBulanIni }}
                        </div>
                        <div style="font-size:11px;color:#065F46;margin-top:3px;">
                          ✅ Konversi Bulan Ini
                        </div>
                      </div>
                    </div>
                    <div class="col-6 col-md-3">
                      <div style="background:#F0FDF4;border-radius:10px;
                                  padding:14px;text-align:center;">
                        <div style="font-size:22px;font-weight:700;color:#6B7280;">
                          {{ $konversiBulanLalu }}
                        </div>
                        <div style="font-size:11px;color:#374151;margin-top:3px;">
                          📅 Konversi Bulan Lalu
                        </div>
                      </div>
                    </div>
                    <div class="col-6 col-md-3">
                      <div style="background:#FEF2F2;border-radius:10px;
                                  padding:14px;text-align:center;">
                        <div style="font-size:22px;font-weight:700;color:#EF4444;">
                          {{ $churnBulanIni }}
                        </div>
                        <div style="font-size:11px;color:#991B1B;margin-top:3px;">
                          🔻 Churn Bulan Ini
                        </div>
                      </div>
                    </div>
                    <div class="col-6 col-md-3">
                      <div style="background:#FFF7F7;border-radius:10px;
                                  padding:14px;text-align:center;">
                        <div style="font-size:22px;font-weight:700;color:#9CA3AF;">
                          {{ $churnBulanLalu }}
                        </div>
                        <div style="font-size:11px;color:#374151;margin-top:3px;">
                          📅 Churn Bulan Lalu
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

        </div>

    @if($totalAll > 0)
    <script>
        const byType = @json($byType);
        const segmentCustomer = @json($segmentCustomer);
        const segmentNonCustomer = @json($segmentNonCustomer);

        const pieOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: ctx => `${ctx.label}: ${ctx.raw}`
                    }
                },
                legend: {
                    position: 'bottom'
                }
            }
        };

        // === PIE 1: Customer vs Non-Customer ===
        new Chart(document.getElementById('businessTypeChart'), {
            type: 'pie',
            data: {
                labels: ['Customer', 'Non-Customer'],
                datasets: [{
                    data: [
                        byType.customer ?? 0,
                        byType.non_customer ?? 0
                    ],
                    backgroundColor: ['#36A2EB', '#FF6384']
                }]
            },
            options: {
                ...pieOptions,
                plugins: {
                    ...pieOptions.plugins,
                    title: {
                        display: true,
                        text: 'Customer vs Non-Customer'
                    }
                }
            }
        });

        // === PIE 2: Segment Customer ===
        new Chart(document.getElementById('segmentCustomerChart'), {
            type: 'pie',
            data: {
                labels: Object.keys(segmentCustomer),
                datasets: [{
                    data: Object.values(segmentCustomer),
                    backgroundColor: [
                        '#36A2EB','#4BC0C0','#9966FF','#FFCE56','#FF9F40'
                    ]
                }]
            },
            options: {
                ...pieOptions,
                plugins: {
                    ...pieOptions.plugins,
                    title: {
                        display: true,
                        text: 'Distribusi Segmen Customer'
                    }
                }
            }
        });

        // === PIE 3: Segment Non-Customer ===
        new Chart(document.getElementById('segmentNonCustomerChart'), {
            type: 'pie',
            data: {
                labels: Object.keys(segmentNonCustomer),
                datasets: [{
                    data: Object.values(segmentNonCustomer),
                    backgroundColor: [
                        '#FF6384','#FF9F40','#FFCE56','#9966FF','#4BC0C0'
                    ]
                }]
            },
            options: {
                ...pieOptions,
                plugins: {
                    ...pieOptions.plugins,
                    title: {
                        display: true,
                        text: 'Distribusi Segmen Non-Customer'
                    }
                }
            }
        });

        const chartCarouselEl = document.getElementById('chartCarousel');
        if (chartCarouselEl) {
            chartCarouselEl.addEventListener('slid.bs.carousel', function () {
                Chart.instances && Object.values(Chart.instances).forEach(
                    function (instance) { instance.resize(); }
                );
            });
        }
        </script>
@endif

<script>
// === LINE CHART: Tren Konversi & Churn (multi-periode) ===
const periodeData = {
    weekly:    @json($weeklyData),
    monthly:   @json($monthlyData),
    sixmonth:  @json($statusChanges),
};

let chartTrenInstance = null;

function renderTrenChart(periode) {
    const ctxTren = document.getElementById('chartTren');
    if (!ctxTren) return;

    const data      = periodeData[periode] || periodeData.sixmonth;
    const labels    = data.map(d => d.label);
    const konversi  = data.map(d => d.konversi);
    const churn     = data.map(d => d.churn);

    if (chartTrenInstance) {
        chartTrenInstance.destroy();
        chartTrenInstance = null;
    }

    chartTrenInstance = new Chart(ctxTren, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Konversi (Non→Customer)',
                    data: konversi,
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16,185,129,0.08)',
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#10B981',
                    pointRadius: 5,
                    pointHoverRadius: 7
                },
                {
                    label: 'Churn (Customer→Non)',
                    data: churn,
                    borderColor: '#EF4444',
                    backgroundColor: 'rgba(239,68,68,0.06)',
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#EF4444',
                    pointRadius: 5,
                    pointHoverRadius: 7
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    backgroundColor: '#1F2937',
                    borderRadius: 8,
                    callbacks: {
                        label: ctx => `${ctx.dataset.label}: ${ctx.raw}`
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, precision: 0 },
                    grid: { color: '#F3F4F6' }
                }
            }
        }
    });

    // Badge: bandingkan total konversi vs churn pada periode ini
    const totalKonversi = konversi.reduce((a, b) => a + b, 0);
    const totalChurn    = churn.reduce((a, b) => a + b, 0);
    const badge = document.getElementById('trenBadge');
    if (badge) {
        if (totalKonversi > totalChurn) {
            badge.textContent      = '✅ Net Positif';
            badge.style.background = '#ECFDF5';
            badge.style.color      = '#065F46';
        } else if (totalChurn > totalKonversi) {
            badge.textContent      = '⚠️ Net Negatif';
            badge.style.background = '#FEF3C7';
            badge.style.color      = '#92400E';
        } else {
            badge.textContent      = '➡️ Seimbang';
            badge.style.background = '#F3F4F6';
            badge.style.color      = '#374151';
        }
    }
}

function updateTrenChart() {
    const sel = document.getElementById('periodeSelector');
    renderTrenChart(sel ? sel.value : 'sixmonth');
}

// Render awal dengan periode 6 bulan
renderTrenChart('sixmonth');
</script>

{{-- P3B: Chart Omset, Paket, Bidang Bisnis --}}
<script>
(function () {
    const omsetLabelMap = {
        'di_bawah_5jt'  : '< 5jt',
        '5jt_20jt'      : '5–20jt',
        '20jt_50jt'     : '20–50jt',
        '50jt_100jt'    : '50–100jt',
        'di_atas_100jt' : '> 100jt'
    };

    // CHART OMSET: grouped bar
    const omsetData = @json($byOmset);
    new Chart(document.getElementById('chartOmset'), {
        type: 'bar',
        data: {
            labels: omsetData.map(d => omsetLabelMap[d.key] || d.key),
            datasets: [
                {
                    label: 'Customer',
                    data: omsetData.map(d => d.customer),
                    backgroundColor: '#3B82F6',
                    borderRadius: 6
                },
                {
                    label: 'Non-Customer',
                    data: omsetData.map(d => d.non_customer),
                    backgroundColor: '#C02016',
                    borderRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    backgroundColor: '#1F2937',
                    borderRadius: 8,
                    callbacks: {
                        label: ctx => `${ctx.dataset.label}: ${ctx.raw}`
                    }
                }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 } }
            }
        }
    });

    // CHART PAKET: doughnut
    const paketData = @json($byPaket);
    if (paketData.length > 0 && document.getElementById('chartPaket')) {
        new Chart(document.getElementById('chartPaket'), {
            type: 'doughnut',
            data: {
                labels: paketData.map(d => d.paket_langganan),
                datasets: [{
                    data: paketData.map(d => d.total),
                    backgroundColor: ['#C02016','#E8453C','#FF6B6B','#FF9E9E','#FFCECE'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: {
                        backgroundColor: '#1F2937',
                        borderRadius: 8,
                        callbacks: {
                            label: ctx => `${ctx.label}: ${ctx.raw} pelanggan`
                        }
                    }
                }
            }
        });
    }

    // CHART BIDANG BISNIS: vertical bar
    const bidangData = @json($byBidang);
    if (bidangData.length > 0 && document.getElementById('chartBidang')) {
        new Chart(document.getElementById('chartBidang'), {
            type: 'bar',
            data: {
                labels: bidangData.map(d => {
                    var l = d.business_detail;
                    return l.length > 15 ? l.substring(0, 15) + '…' : l;
                }),
                datasets: [{
                    label: 'Jumlah',
                    data: bidangData.map(d => d.total),
                    backgroundColor: ['#C02016','#D4342A','#E8453C','#F55E56','#FF7570'],
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1F2937',
                        borderRadius: 8,
                        callbacks: {
                            title: ctx => bidangData[ctx[0].dataIndex].business_detail
                        }
                    }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 } }
                }
            }
        });
    }
})();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
