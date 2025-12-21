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

                @php
                    $isSorted = fn($col) => ($sortBy ?? 'created_at') === $col;

                    $nextDir = function ($col) use ($sortBy, $sortDir) {
                        if (($sortBy ?? null) === $col) {
                            return ($sortDir ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        }
                        return 'asc'; // default klik pertama
                    };

                    $sortUrl = function ($col) {
                        return request()->fullUrlWithQuery([
                            'sort_by' => $col,
                            'sort_dir' => request('sort_dir') === 'asc' ? 'desc' : 'asc',
                        ]);
                    };
                @endphp

                <table class="table table-striped align-middle table-fixed">
                    <thead>
                        <tr>

                            <th>
                            <a href="{{ request()->fullUrlWithQuery([
                                    'sort_by' => 'name',
                                    'sort_dir' => ($sortBy === 'name' && $sortDir === 'asc') ? 'desc' : 'asc'
                                ]) }}"
                                class="text-decoration-none text-dark d-inline-flex align-items-center gap-1">
                                Nama
                                @if($sortBy === 'name')
                                <i class="bi {{ $sortDir === 'asc' ? 'bi-caret-up-fill' : 'bi-caret-down-fill' }}"></i>
                                @endif
                            </a>
                            </th>

                            <th>
                            <a href="{{ request()->fullUrlWithQuery([
                                    'sort_by' => 'address',
                                    'sort_dir' => ($sortBy === 'address' && $sortDir === 'asc') ? 'desc' : 'asc'
                                ]) }}"
                                class="text-decoration-none text-dark d-inline-flex align-items-center gap-1">
                                Alamat
                                @if($sortBy === 'address')
                                <i class="bi {{ $sortDir === 'asc' ? 'bi-caret-up-fill' : 'bi-caret-down-fill' }}"></i>
                                @endif
                            </a>
                            </th>

                            <th>
                            <a href="{{ request()->fullUrlWithQuery([
                                    'sort_by' => 'coordinates',
                                    'sort_dir' => ($sortBy === 'coordinates' && $sortDir === 'asc') ? 'desc' : 'asc'
                                ]) }}"
                                class="text-decoration-none text-dark d-inline-flex align-items-center gap-1">
                                Koordinat
                                @if($sortBy === 'coordinates')
                                <i class="bi {{ $sortDir === 'asc' ? 'bi-caret-up-fill' : 'bi-caret-down-fill' }}"></i>
                                @endif
                            </a>
                            </th>

                            <th>
                            <a href="{{ request()->fullUrlWithQuery([
                                    'sort_by' => 'type',
                                    'sort_dir' => ($sortBy === 'type' && $sortDir === 'asc') ? 'desc' : 'asc'
                                ]) }}"
                                class="text-decoration-none text-dark d-inline-flex align-items-center gap-1">

                                Tipe

                                @if($sortBy === 'type')
                                <i class="bi {{ $sortDir === 'asc' ? 'bi-caret-up-fill' : 'bi-caret-down-fill' }}"></i>
                                @endif
                            </a>
                            </th>

                            <th>
                            <a href="{{ request()->fullUrlWithQuery([
                                    'sort_by' => 'segment',
                                    'sort_dir' => ($sortBy === 'segment' && $sortDir === 'asc') ? 'desc' : 'asc'
                                ]) }}"
                                class="text-decoration-none text-dark d-inline-flex align-items-center gap-1">

                                Segmen

                                @if($sortBy === 'segment')
                                <i class="bi {{ $sortDir === 'asc' ? 'bi-caret-up-fill' : 'bi-caret-down-fill' }}"></i>
                                @endif
                            </a>
                            </th>

                            <th>
                            <a href="{{ request()->fullUrlWithQuery([
                                    'sort_by' => 'created_at',
                                    'sort_dir' => ($sortBy === 'created_at' && $sortDir === 'asc') ? 'desc' : 'asc'
                                ]) }}"
                                class="text-decoration-none text-dark d-inline-flex align-items-center gap-1">

                                Dibuat

                                @if($sortBy === 'created_at')
                                <i class="bi {{ $sortDir === 'asc' ? 'bi-caret-up-fill' : 'bi-caret-down-fill' }}"></i>
                                @endif
                            </a>
                            </th>

                            <th style="width:170px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($locations as $loc)
                            <tr>
                                <td>
                                <div class="text-truncate" style="max-width: 200px;" title="{{ $loc->name }}">
                                    {{ $loc->name }}
                                </div>
                                </td>

                                <td>
                                <div class="text-truncate" style="max-width: 280px;" title="{{ $loc->address }}">
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

                                <td>
                                    <div class="text-truncate" style="max-width: 280px;" title="{{ $loc->created_at?->format('Y-m-d') }}">
                                    {{ $loc->created_at?->format('Y-m-d') }}
                                </td>

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
                @php
                $from = $locations->firstItem() ?? 0;
                $to   = $locations->lastItem() ?? 0;
                $total = $locations->total();
                @endphp

                <div class="d-flex align-items-center justify-content-between mt-3 flex-wrap gap-2">
                {{-- kiri: rows per page + showing --}}
                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted">Rows per page</span>

                    <form id="perPageForm" method="GET" action="{{ url()->current() }}" class="d-inline">
                    {{-- pertahankan semua query lain --}}
                    @foreach(request()->except('per_page', 'page') as $k => $v)
                        @if(is_array($v))
                        @foreach($v as $vv)
                            <input type="hidden" name="{{ $k }}[]" value="{{ $vv }}">
                        @endforeach
                        @else
                        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                        @endif
                    @endforeach

                    <select name="per_page" id="perPageSelect" class="form-select form-select-sm" style="width:90px">
                        <option value="10"  {{ ($perPage ?? 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="25"  {{ ($perPage ?? 10) == 25 ? 'selected' : '' }}>25</option>
                        <option value="50"  {{ ($perPage ?? 10) == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ ($perPage ?? 10) == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    </form>

                    <span class="text-muted">Showing {{ $from }} to {{ $to }} of {{ $total }} results</span>
                </div>

                {{-- kanan: pagination --}}
                <div>
                    {{ $locations->withQueryString()->links() }}
                </div>
                </div>
        @endif
    </div>
</div>


<script>
  const perPageSelect = document.getElementById('perPageSelect');
  const perPageForm = document.getElementById('perPageForm');

  if (perPageSelect && perPageForm) {
    perPageSelect.addEventListener('change', () => perPageForm.submit());
  }
</script>

@endsection