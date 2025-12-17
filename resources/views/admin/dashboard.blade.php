@extends('admin.layout')

@section('title', 'Dashboard Admin - BizzMap')

@section('content')
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
@endsection
