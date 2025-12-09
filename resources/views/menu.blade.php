<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Navigasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/stylemenu.css') }}">
</head>
<body>
    <header class="header">
        <a href="{{ url('/landing') }}"><h1>BIZZ MAP</h1></a>
        <nav class="navbar">
            <a href="{{ route('logout') }}" class="btn btn-logout" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </nav>
    </header>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card menu-card text-center">
                    <div class="card-body">
                        <i class="fas fa-map-marked-alt fa-3x"></i>
                        <h5 class="card-title mt-3">PETA</h5>
                        <a href="{{ url('/geo') }}" class="btn btn-primary">Lihat Peta</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card menu-card text-center">
                    <div class="card-body">
                        <i class="fas fa-users fa-3x"></i>
                        <h5 class="card-title mt-3">DEMOGRAFI</h5>  
                        <a href="{{ url('/demografi') }}" class="btn btn-primary">Lihat Demografi</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card menu-card text-center">
                    <div class="card-body">
                        <i class="fas fa-chart-line fa-3x"></i>
                        <h5 class="card-title mt-3">ANALYTICS</h5>
                        <a href="{{ url('/analytics') }}" class="btn btn-primary">Lihat Analytics</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
