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

      {{-- Informasi Lokasi --}}
      <h6 class="text-danger fw-semibold mb-2 mt-1">Informasi Lokasi</h6>
      <div class="mb-3">
        <label class="form-label">Nama <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $location->name) }}" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Alamat <span class="text-danger">*</span></label>
        <input type="text" name="address" class="form-control" value="{{ old('address', $location->address) }}" required>
      </div>
      <div class="row g-2 mb-1">
        <div class="col-md-6 mb-3">
          <label class="form-label">Latitude <span class="text-danger">*</span></label>
          <input type="number" step="any" name="latitude" class="form-control" value="{{ old('latitude', $location->latitude) }}" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Longitude <span class="text-danger">*</span></label>
          <input type="number" step="any" name="longitude" class="form-control" value="{{ old('longitude', $location->longitude) }}" required>
        </div>
      </div>
      <div class="row g-2 mb-1">
        <div class="col-md-6 mb-3">
          <label class="form-label">Tipe <span class="text-danger">*</span></label>
          <select name="type" class="form-select" required>
            <option value="customer" {{ old('type', $location->type) === 'customer' ? 'selected' : '' }}>customer</option>
            <option value="non_customer" {{ old('type', $location->type) === 'non_customer' ? 'selected' : '' }}>non_customer</option>
          </select>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Segmen <span class="text-danger">*</span></label>
          <select name="segment" class="form-select" required>
            @foreach(['sekolah','ruko','hotel','multifinance','health','ekspedisi','energi'] as $seg)
              <option value="{{ $seg }}" {{ old('segment', $location->segment) === $seg ? 'selected' : '' }}>
                {{ $seg }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      <hr class="my-3">

      {{-- Data Pemilik --}}
      <h6 class="text-danger fw-semibold mb-2">Data Pemilik</h6>
      <div class="row g-2 mb-1">
        <div class="col-md-6 mb-3">
          <label class="form-label">Nama Pemilik</label>
          <input type="text" name="owner_name" class="form-control" maxlength="100"
                 value="{{ old('owner_name', $location->owner_name) }}"
                 placeholder="Nama pemilik / penanggungjawab">
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">No. Telepon</label>
          <input type="text" name="phone" class="form-control" maxlength="20"
                 value="{{ old('phone', $location->phone) }}"
                 placeholder="08xx-xxxx-xxxx">
        </div>
      </div>

      <hr class="my-3">

      {{-- Detail Bisnis --}}
      <h6 class="text-danger fw-semibold mb-2">Detail Bisnis</h6>
      <div class="mb-3">
        <label class="form-label">Bidang Bisnis</label>
        <input type="text" name="business_detail" class="form-control" maxlength="200"
               value="{{ old('business_detail', $location->business_detail) }}"
               placeholder="Contoh: ritel makanan, jasa logistik">
      </div>
      <div class="row g-2 mb-1">
        <div class="col-md-6 mb-3">
          <label class="form-label">Omset per Bulan</label>
          <select name="omset" class="form-select">
            <option value="">-- Pilih Omset --</option>
            @foreach([
              'di_bawah_5jt'  => 'Di Bawah Rp 5 Juta',
              '5jt_20jt'      => 'Rp 5 – 20 Juta',
              '20jt_50jt'     => 'Rp 20 – 50 Juta',
              '50jt_100jt'    => 'Rp 50 – 100 Juta',
              'di_atas_100jt' => 'Di Atas Rp 100 Juta',
            ] as $val => $label)
              <option value="{{ $val }}" {{ old('omset', $location->omset) === $val ? 'selected' : '' }}>
                {{ $label }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Paket Langganan</label>
          <input type="text" name="paket_langganan" class="form-control" maxlength="100"
                 value="{{ old('paket_langganan', $location->paket_langganan) }}"
                 placeholder="Contoh: IndiHome 20 Mbps">
        </div>
      </div>

      <div class="d-flex gap-2 mt-2">
        <button class="btn btn-primary" type="submit">Simpan</button>
        <a href="{{ route('admin.locations') }}" class="btn btn-outline-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
