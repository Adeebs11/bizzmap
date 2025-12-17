<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - BizzMap</title>

    {{-- Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand">BizzMap Admin</span>
        <div class="ms-auto d-flex gap-2">
            <a href="{{ route('admin.pending') }}" class="btn btn-warning btn-sm">Pending</a>
            <a href="{{ url('/menu') }}" class="btn btn-outline-light btn-sm">Menu</a>
        </div>
    </div>
</nav>

<div class="container py-4">
    <h3 class="mb-4">Dashboard</h3>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Data Pending</h5>
                    <p class="display-6 mb-0">{{ $pendingCount }}</p>
                    <small class="text-muted">Menunggu verifikasi admin</small>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Data Approved</h5>
                    <p class="display-6 mb-0">{{ $approvedCount }}</p>
                    <small class="text-muted">Sudah tampil di peta</small>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.pending') }}" class="btn btn-primary">Lihat Data Pending</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
