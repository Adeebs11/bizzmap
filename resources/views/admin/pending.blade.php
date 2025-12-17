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
                                            <button class="btn btn-success btn-sm" type="submit">Approve</button>
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
@endsection
