@extends('admin.layout')

@section('title', 'Edit User - BizzMap')

@section('content')
<h3 class="mb-3">Edit User</h3>

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="card shadow-sm">
    @csrf
    @method('PUT')

    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select" required>
                <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User (SA / AR)</option>
                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Password (opsional)</label>
            <input type="password" name="password" class="form-control" placeholder="Isi jika ingin reset password">
            <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
            <a href="{{ route('admin.users') }}" class="btn btn-secondary">Batal</a>
        </div>
    </div>
</form>
@endsection
