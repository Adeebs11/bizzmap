<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
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

            public function locations(Request $request)
        {
            // filter
            $type = $request->query('type');       // customer / non_customer / null
            $segment = $request->query('segment'); // sekolah/ruko/... / null
            $q = $request->query('q');             // search

            // sort
            $sortBy = $request->query('sort_by', 'created_at'); // created_at / type / segment
            $sortDir = $request->query('sort_dir', 'desc');     // asc / desc

            // whitelist untuk keamanan
            $allowedSortBy = ['created_at', 'type', 'segment', 'name', 'address', 'coordinates'];
            if (!in_array($sortBy, $allowedSortBy, true)) $sortBy = 'created_at';

            $allowedSortDir = ['asc', 'desc'];
            if (!in_array($sortDir, $allowedSortDir, true)) $sortDir = 'desc';

            $allowedSegments = ['sekolah','ruko','hotel','multifinance','health','ekspedisi','energi'];

            $query = Location::where('status', 'approved');

            // filter type
            if ($type === 'customer' || $type === 'non_customer') {
                $query->where('type', $type);
            }

            // filter segment
            if ($segment && in_array($segment, $allowedSegments, true)) {
                $query->where('segment', $segment);
            }

            // search
            if ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('address', 'like', "%{$q}%");
                });
            }

            // sorting
            if ($sortBy === 'coordinates') {
            // urutkan latitude dulu, lalu longitude
            $query->orderBy('latitude', $sortDir)
                ->orderBy('longitude', $sortDir);
            } else {
            $query->orderBy($sortBy, $sortDir);
}


            $locations = $query->paginate(10)->withQueryString();

            return view('admin.locations', compact(
                'locations',
                'type',
                'segment',
                'sortBy',
                'sortDir',
                'q'
            ));
        }

        public function editLocation($id)
    {
        $location = \App\Models\Location::findOrFail($id);
        return view('admin.locations_edit', compact('location'));
    }

        public function updateLocation(\Illuminate\Http\Request $request, $id)
    {
        $location = \App\Models\Location::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'type' => 'required|in:customer,non_customer',
            'segment' => 'required|in:sekolah,ruko,hotel,multifinance,health,ekspedisi,energi',
        ]);

        $location->update($validated);

        return redirect()->route('admin.locations')->with('success', 'Data lokasi berhasil diperbarui.');
    }

    public function deleteLocation($id)
    {
        $location = \App\Models\Location::findOrFail($id);
        $location->delete();

        return redirect()->back()->with('success', 'Data lokasi berhasil dihapus.');
    }

        public function bulkApprove(Request $request)
    {
        $validated = $request->validate([
            'selected' => 'required|array|min:1',
            'selected.*' => 'integer',
        ]);

        $ids = $validated['selected'];

        $updated = DB::transaction(function () use ($ids) {
            return Location::whereIn('id', $ids)
                ->where('status', 'pending')
                ->update(['status' => 'approved']);
        });

        return redirect()->back()->with('success', "{$updated} data berhasil di-approve.");
    }

    public function bulkReject(Request $request)
    {
        $validated = $request->validate([
            'selected' => 'required|array|min:1',
            'selected.*' => 'integer',
        ]);

        $ids = $validated['selected'];

        $deleted = DB::transaction(function () use ($ids) {
            return Location::whereIn('id', $ids)
                ->where('status', 'pending')
                ->delete();
        });

        return redirect()->back()->with('success', "{$deleted} data berhasil di-reject (dihapus).");
    }


}
