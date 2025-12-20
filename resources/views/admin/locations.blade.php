@extends('admin.layout')

@section('title', 'Data Customer & Non-Cust - BizzMap')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <h3 class="mb-0">Data Customer & Non-Cust</h3>
</div>

<form class="d-flex flex-wrap align-items-center gap-2 mb-3"
      method="GET" action="{{ route('admin.locations') }}">

  {{-- Filter kiri --}}
  <select name="type" class="form-select" style="width:180px">
    <option value="">Semua Tipe</option>
    <option value="customer" {{ $type==='customer'?'selected':'' }}>Customer</option>
    <option value="non_customer" {{ $type==='non_customer'?'selected':'' }}>Non-Customer</option>
  </select>

  <select name="segment" class="form-select" style="width:180px">
    <option value="">Semua Segmen</option>
    <option value="sekolah" {{ ($segment??'')==='sekolah'?'selected':'' }}>Sekolah</option>
    <option value="ruko" {{ ($segment??'')==='ruko'?'selected':'' }}>Ruko</option>
    <option value="hotel" {{ ($segment??'')==='hotel'?'selected':'' }}>Hotel</option>
    <option value="multifinance" {{ ($segment??'')==='multifinance'?'selected':'' }}>Multifinance</option>
    <option value="health" {{ ($segment??'')==='health'?'selected':'' }}>Health</option>
    <option value="ekspedisi" {{ ($segment??'')==='ekspedisi'?'selected':'' }}>Ekspedisi</option>
    <option value="energi" {{ ($segment??'')==='energi'?'selected':'' }}>Energy</option>
  </select>

  <select name="sort_by" class="form-select" style="width:180px">
    <option value="created_at" {{ ($sortBy??'created_at')==='created_at'?'selected':'' }}>Urut: Tanggal</option>
    <option value="type" {{ ($sortBy??'')==='type'?'selected':'' }}>Urut: Tipe</option>
    <option value="segment" {{ ($sortBy??'')==='segment'?'selected':'' }}>Urut: Segmen</option>
  </select>

  {{-- Search --}}
  <input type="text" name="q" value="{{ $q??'' }}"
         class="form-control" style="max-width:450px"
         placeholder="Cari nama / alamat...">

<div class="d-flex gap-2">
    <button class="btn btn-primary btn-sm px-3" type="submit" title="Terapkan Filter">
        <i class="bi bi-funnel-fill bi-bold"></i>
    </button>

    <a class="btn btn-outline-secondary btn-sm px-3"
       href="{{ route('admin.locations') }}" title="Reset Filter">
        <i class="bi bi-arrow-counterclockwise bi-bold"></i>
    </a>

    <button type="submit" name="sort_dir" value="asc"
            class="btn btn-outline-primary btn-sm px-3 {{ ($sortDir ?? 'desc') === 'asc' ? 'active' : '' }}"
            title="Urut Naik (ASC)">
        <i class="bi bi-sort-up-alt bi-bold"></i>
    </button>

    <button type="submit" name="sort_dir" value="desc"
            class="btn btn-outline-primary btn-sm px-3 {{ ($sortDir ?? 'desc') === 'desc' ? 'active' : '' }}"
            title="Urut Turun (DESC)">
        <i class="bi bi-sort-down bi-bold"></i>
    </button>
</div>

  </div>
</form>

<div class="card shadow-sm">
    <div class="card-body">
        @if($locations->isEmpty())
            <p class="mb-0 text-muted">Belum ada data approved.</p>
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
                            <th>Dibuat</th>
                            <th style="width:170px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($locations as $loc)
                            <tr>
                                <td>{{ $loc->name }}</td>
                                <td>
                                <div class="text-truncate" style="max-width: 360px;" title="{{ $loc->address }}">
                                    {{ $loc->address }}
                                </div>
                                </td>

                                <td class="text-nowrap">{{ $loc->latitude }}, {{ $loc->longitude }}</td>
                                <td>
                                    <span class="badge {{ $loc->type === 'customer' ? 'text-bg-success' : 'text-bg-secondary' }}">
                                        {{ $loc->type }}
                                    </span>
                                </td>
                                <td>{{ $loc->segment }}</td>
                                <td>{{ $loc->created_at?->format('Y-m-d') }}</td>

<td class="text-center text-nowrap">
  <div class="d-inline-flex gap-2">
    <a href="{{ route('admin.locations.edit', $loc->id) }}" class="btn btn-success btn-sm">
      Edit
    </a>

    <form method="POST" action="{{ route('admin.locations.delete', $loc->id) }}"
      onsubmit="return confirm('Hapus data ini?');">
      @csrf
      @method('DELETE')
      <button class="btn btn-danger btn-sm" type="submit">Delete</button>
    </form>
  </div>
</td>
                            </tr>
                            
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $locations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
