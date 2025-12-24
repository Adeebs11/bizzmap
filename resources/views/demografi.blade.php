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
            <div class="row text-center mb-4">
                <div class="col-md-3 info-box">
                    <i class="fas fa-map-marker-alt"></i>
                    <h2>8</h2>
                    <p>Kecamatan</p>
                </div>
                <div class="col-md-3 info-box indibiz-count">
                    <i class="fas fa-briefcase"></i>
                    <h2>{{ $customerTotal }}</h2>
                    <p>Customer</p>
                </div>
                <div class="col-md-3 info-box non-customer-count">
                    <i class="fas fa-briefcase"></i>
                    <h2>{{ $nonCustomerTotal }}</h2>
                    <p>Non-Customer</p>
                </div>

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


                <div class="row gx-3 gy-2 mb-3">
                <div class="col-lg-6 mx-auto">
                    <div class="chart-card chart-lg">
                    <canvas id="businessTypeChart"></canvas>
                    </div>
                </div>
                </div>

                <div class="row gx-3 gy-2">
                <div class="col-lg-6">
                    <div class="chart-card chart-md">
                    <canvas id="segmentCustomerChart"></canvas>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="chart-card chart-md">
                    <canvas id="segmentNonCustomerChart"></canvas>
                    </div>
                </div>
                </div>

    </div>

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
        </script>

</body>
</html>
