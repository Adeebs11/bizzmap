<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demografi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/styledemografi.css') }}">
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
                    <h2>0</h2>
                    <p>Segmen Indibiz</p>
                </div>
                <div class="col-md-3 info-box non-customer-count">
                    <i class="fas fa-briefcase"></i>
                    <h2>0</h2>
                    <p>Segmen Non-Customer</p>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 chart-container">
                    <canvas id="businessTypeChart"></canvas>
                </div>
                <div class="col-md-6 chart-container">
                    <canvas id="newChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/demografi.js') }}"></script>
</body>
</html>
