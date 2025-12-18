<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin - BizzMap')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <style>
        .sidebar {
            width: 260px;
            min-height: 100vh;
        }
        .sidebar .nav-link.active {
            font-weight: 600;
        }
        .content {
            min-height: 100vh;
        }
    </style>
</head>
<body class="bg-light">

<div class="d-flex">
    {{-- Sidebar --}}
    <aside class="sidebar bg-dark text-white p-3">
        <div class="mb-4">
            <div class="fs-5 fw-semibold">BizzMap Admin</div>
            <div class="small text-white-50">Panel Verifikasi</div>
        </div>

        <ul class="nav nav-pills flex-column gap-1">
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active bg-primary' : '' }}"
                   href="{{ route('admin.dashboard') }}">
                    Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.pending') ? 'active bg-primary' : '' }}"
                   href="{{ route('admin.pending') }}">
                    Data Pending
                </a>
            </li>

                <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.locations') ? 'active bg-primary' : '' }}"
                    href="{{ route('admin.locations') }}">
                    Data Customer & Non-Cust
                </a>
                </li>

            {{-- Placeholder untuk langkah berikutnya --}}
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeIs('admin.users') ? 'active bg-primary' : '' }}"
                href="{{ route('admin.users') }}">
                    Kelola User
                </a>
            </li>
        </ul>

        <hr class="border-secondary my-4">

        <div class="d-flex flex-column gap-2">
            <a href="{{ url('/menu') }}" class="btn btn-outline-light btn-sm">Kembali ke Menu</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-outline-warning btn-sm w-100" type="submit">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Content --}}
    <main class="content flex-grow-1">
        <div class="container py-4">
            @yield('content')
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
