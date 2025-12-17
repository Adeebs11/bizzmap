<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pending Approval - BizzMap</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">BizzMap Admin</a>
        <div class="ms-auto d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-sm">Dashboard</a>
            <a href="{{ url('/menu') }}" class="btn btn-outline-light btn-sm">Menu</a>
        </div>
    </div>
</nav>

<div class="container py-4">
    <h3 class="mb-3">Data Pending</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            @if($locations->isEmpty())
                <p class="mb-0 text-muted">Belum ada data pending.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Koordinat</th>
                                <th>Tipe</th>
                                <th>Segmen</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($locations as $loc)
                                <tr>
                                    <td>{{ $loc->name }}</td>
                                    <td style="max-width: 320px;">{{ $loc->address }}</td>
                                    <td>{{ $loc->latitude }}, {{ $loc->longitude }}</td>
                                    <td>{{ $loc->type }}</td>
                                    <td>{{ $loc->segment }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.approve', $loc->id) }}">
                                            @csrf
                                            <button class="btn btn-success btn-sm" type="submit">
                                                Approve
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
