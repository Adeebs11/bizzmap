@extends('admin.layout')

@section('title', 'Data Pending - BizzMap')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h3 class="mb-0">Data Pending</h3>
    </div>

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
                                <th style="width: 180px;">Nama</th>
                                <th>Alamat</th>
                                <th style="width: 210px;">Koordinat</th>
                                <th style="width: 140px;">Tipe</th>
                                <th style="width: 140px;">Segmen</th>
                                <th style="width: 170px;" class="text-center">Aksi</th>
                            </tr>
                            </thead>
                        <tbody>
                            @foreach($locations as $loc)
                                <tr>
                                    <td>{{ $loc->name }}</td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 420px;" title="{{ $loc->address }}">
                                            {{ $loc->address }}
                                        </div>
                                        </td>

                                        <td class="text-nowrap">{{ $loc->latitude }}, {{ $loc->longitude }}</td>
                                        <td class="text-nowrap">{{ $loc->type }}</td>
                                        <td class="text-nowrap">{{ $loc->segment }}</td>

                                        <td class="text-center text-nowrap">
                                        <div class="d-inline-flex gap-2">
                                            <form method="POST" action="{{ route('admin.approve', $loc->id) }}">
                                            @csrf
                                            <button class="btn btn-success btn-sm" type="submit">Approve</button>
                                            </form>

                                            <form method="POST" action="{{ route('admin.reject', $loc->id) }}"
                                            onsubmit="return confirm('Reject data ini? Data akan dihapus.');">
                                            @csrf
                                            <button class="btn btn-danger btn-sm" type="submit">Reject</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
