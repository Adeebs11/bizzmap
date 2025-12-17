@extends('admin.layout')

@section('title', 'Tambah User - BizzMap')

@section('content')
<h3 class="mb-3">Tambah User</h3>

<form method="POST" action="{{ route('admin.users.store') }}" class="card shadow-sm">
    @csrf
    <div class="card-body">

        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select" required>
                <option value="user">User (SA / AR)</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.users') }}" class="btn btn-secondary">Batal</a>
        </div>
    </div>
</form>
@endsection
