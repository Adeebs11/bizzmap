<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

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
}
