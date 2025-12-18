@extends('admin.layout')

@section('title', 'Edit Data Lokasi')

@section('content')
<h3 class="mb-3">Edit Data Lokasi</h3>

@if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="card shadow-sm">
  <div class="card-body">
    <form method="POST" action="{{ route('admin.locations.update', $location->id) }}">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $location->name) }}" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Alamat</label>
        <input type="text" name="address" class="form-control" value="{{ old('address', $location->address) }}" required>
      </div>

      <div class="row g-2">
        <div class="col-md-6 mb-3">
          <label class="form-label">Latitude</label>
          <input type="number" step="any" name="latitude" class="form-control" value="{{ old('latitude', $location->latitude) }}" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Longitude</label>
          <input type="number" step="any" name="longitude" class="form-control" value="{{ old('longitude', $location->longitude) }}" required>
        </div>
      </div>

      <div class="row g-2">
        <div class="col-md-6 mb-3">
          <label class="form-label">Tipe</label>
          <select name="type" class="form-select" required>
            <option value="customer" {{ old('type', $location->type) === 'customer' ? 'selected' : '' }}>customer</option>
            <option value="non_customer" {{ old('type', $location->type) === 'non_customer' ? 'selected' : '' }}>non_customer</option>
          </select>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Segmen</label>
          <select name="segment" class="form-select" required>
            @foreach(['sekolah','ruko','hotel','multifinance','health','ekspedisi','energi'] as $seg)
              <option value="{{ $seg }}" {{ old('segment', $location->segment) === $seg ? 'selected' : '' }}>
                {{ $seg }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="d-flex gap-2">
        <button class="btn btn-primary" type="submit">Simpan</button>
        <a href="{{ route('admin.locations') }}" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
