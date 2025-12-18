<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    // GET: ambil data yang sudah approved untuk ditampilkan di peta
    public function approved()
    {
        $locations = Location::where('status', 'approved')
            ->select('id','name','address','latitude','longitude','type','segment')
            ->latest()
            ->get();

        return response()->json($locations);
    }

    // POST: simpan data dari user sebagai pending
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'type' => 'required|in:customer,non_customer',
            'segment' => 'required|in:sekolah,ruko,hotel,multifinance,health,ekspedisi,energi',
        ]);

        $location = Location::create([
            'user_id' => $request->user()->id,
            'name' => $validated['name'],
            'address' => $validated['address'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'type' => $validated['type'],
            'segment' => $validated['segment'],
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Data berhasil dikirim dan menunggu verifikasi admin.',
            'id' => $location->id
        ], 201);
    }
}
