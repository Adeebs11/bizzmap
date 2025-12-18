<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    // Halaman dashboard admin
    public function dashboard()
    {
        $pendingCount = Location::where('status', 'pending')->count();
        $approvedCount = Location::where('status', 'approved')->count();

        return view('admin.dashboard', compact('pendingCount', 'approvedCount'));
    }

    // List data yang pending
    public function pending()
    {
        $locations = Location::where('status', 'pending')
            ->latest()
            ->get();

        return view('admin.pending', compact('locations'));
    }

    // Approve data pending
    public function approve($id)
    {
        $location = Location::findOrFail($id);

        // hanya approve jika masih pending (opsional safety)
        if ($location->status === 'pending') {
            $location->status = 'approved';
            $location->save();
        }

        return redirect()->back()->with('success', 'Data berhasil di-approve.');
    }

        public function users()
    {
        $users = User::orderBy('role', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.users', compact('users'));
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // keamanan: jangan biarkan admin menghapus dirinya sendiri
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        // opsional: jangan hapus admin lain
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Akun admin tidak bisa dihapus.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Akun user berhasil dihapus.');
    }

        public function createUser()
        {
            return view('admin.user-create');
        }

        public function storeUser(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'role' => 'required|in:admin,user',
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            return redirect()->route('admin.users')
                ->with('success', 'Akun user berhasil dibuat.');
        }

        public function updateUserRole(Request $request, $id)
        {
            $request->validate([
                'role' => 'required|in:admin,user'
            ]);

            $user = User::findOrFail($id);

            if ($user->id === auth()->id()) {
                return back()->with('error', 'Tidak bisa mengubah role akun sendiri.');
            }

            $user->role = $request->role;
            $user->save();

            return back()->with('success', 'Role user berhasil diperbarui.');
        }

                public function editUser($id)
        {
            $user = User::findOrFail($id);
            return view('admin.user-edit', compact('user'));
        }

        public function updateUser(Request $request, $id)
        {
            $user = User::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'role' => 'required|in:admin,user',
                'password' => 'nullable|min:6',
            ]);

            // Hindari kamu “ngunci diri sendiri” jadi user
            if ($user->id === auth()->id() && $request->role !== 'admin') {
                return back()->with('error', 'Tidak bisa menurunkan role akun admin yang sedang login.');
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;

            if ($request->filled('password')) {
                $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
            }

            $user->save();

            return redirect()->route('admin.users')->with('success', 'User berhasil diperbarui.');
        }

        public function reject($id)
        {
            $location = \App\Models\Location::findOrFail($id);

            // hanya boleh reject jika masih pending
            if ($location->status === 'pending') {
                $location->delete();
            }

            return redirect()->back()->with('success', 'Data pending berhasil dihapus (reject).');
        }

}
