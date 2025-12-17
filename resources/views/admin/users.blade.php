@extends('admin.layout')

@section('title', 'Kelola User - BizzMap')

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-3">
        <h3 class="mb-0">Kelola User</h3>

        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
            + Add New
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            @if($users->isEmpty())
                <p class="mb-0 text-muted">Belum ada user terdaftar.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Dibuat</th>
                                <th style="width:120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $u)
                                <tr>
                                    <td>{{ $u->name }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td>
                                        <span class="badge {{ $u->role === 'admin' ? 'text-bg-warning' : 'text-bg-secondary' }}">
                                            {{ $u->role }}
                                        </span>
                                    </td>
                                    <td>{{ $u->created_at?->format('Y-m-d') }}</td>
                                    <td class="d-flex gap-2">
                                        <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-success btn-sm">Edit</a>

                                        @if($u->role === 'admin')
                                            <button class="btn btn-outline-secondary btn-sm" disabled>Protected</button>
                                        @else
                                            <form method="POST" action="{{ route('admin.users.delete', $u->id) }}"
                                                onsubmit="return confirm('Yakin hapus user ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                                            </form>
                                        @endif
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
