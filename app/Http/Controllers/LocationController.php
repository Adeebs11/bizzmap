<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:5120', // max 5MB
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();

        $handle = fopen($path, 'r');
        if (!$handle) {
            return response()->json([
                'message' => 'File tidak bisa dibaca.'
            ], 422);
        }

        $parseRow = function ($raw) {
        if (!is_array($raw) || count($raw) === 0) return null;

        // Kalau normal: kolomnya sudah terpisah
        if (count($raw) > 1) return $raw;

        // Kalau "rusak" versi Excel: semua kolom jadi 1 string
        $line = trim((string) $raw[0]);

        // buang BOM kalau ada
        $line = preg_replace('/^\xEF\xBB\xBF/', '', $line);

        // buang quote pembungkus 1 baris: "a;b;c"
        if (strlen($line) >= 2 && $line[0] === '"' && substr($line, -1) === '"') {
            $line = substr($line, 1, -1);
        }

        // Deteksi delimiter di dalam string
        $delimiter = (substr_count($line, ';') >= substr_count($line, ',')) ? ';' : ',';

        // Pecah jadi kolom
        // (str_getcsv aman kalau nanti ada field yang benar-benar quoted)
        return str_getcsv($line, $delimiter, '"', "\\");
    };


        // Baca header
        $firstLine = fgets($handle);
        if ($firstLine === false) {
            fclose($handle);
            return response()->json(['message' => 'CSV kosong.'], 422);
        }

        $commaCount = substr_count($firstLine, ',');
        $semiCount  = substr_count($firstLine, ';');
        $delimiter = ($semiCount > $commaCount) ? ';' : ',';

        rewind($handle);

            $rawHeader = fgetcsv($handle);
            $rawHeader = $parseRow($rawHeader);

            if (!$rawHeader) {
                fclose($handle);
                return response()->json(['message' => 'CSV kosong / tidak memiliki header.'], 422);
            }

            $header = array_map(function ($h) {
                $h = trim((string) $h);
                $h = preg_replace('/^\xEF\xBB\xBF/', '', $h); // BOM safety
                $h = Str::of($h)->lower()->replace(' ', '_')->toString();
                return $h;
            }, $rawHeader);


        // Terima variasi kolom:
        // name, address, latitude, longitude, type, segment
        // atau: segmen (seperti di geo.blade lama)
        $required = ['name', 'address', 'latitude', 'longitude', 'type'];
        foreach ($required as $col) {
            if (!in_array($col, $header, true)) {
                fclose($handle);
                return response()->json([
                    'message' => "Kolom wajib tidak ditemukan: {$col}. Pastikan header CSV sesuai."
                ], 422);
            }
        }

        $segmentKey = in_array('segment', $header, true) ? 'segment' : (in_array('segmen', $header, true) ? 'segmen' : null);
        if (!$segmentKey) {
            fclose($handle);
            return response()->json([
                'message' => "Kolom wajib tidak ditemukan: segment/segmen. Pastikan header CSV sesuai."
            ], 422);
        }

        $rowsToInsert = [];
        $errors = [];
        $line = 1; // header = line 1

        // Helper mapping type
        $mapType = function ($value) {
            $v = strtolower(trim((string) $value));
            if ($v === 'customer') return 'customer';
            if ($v === 'non_customer') return 'non_customer';
            if ($v === 'non-customer') return 'non_customer';
            if ($v === 'indibiz') return 'customer';
            if (str_contains($v, 'non')) return 'non_customer';
            return null;
        };

        // Helper mapping segment
        $mapSegment = function ($value) {
            $v = strtolower(trim((string) $value));

            // rapikan variasi penulisan
            $v = str_replace(['indibiz ', 'indibiz_'], '', $v);
            $v = str_replace(['multi finance', 'multi-finance'], 'multifinance', $v);
            $v = str_replace('energy', 'energi', $v);

            $allowed = ['sekolah','ruko','hotel','multifinance','health','ekspedisi','energi'];
            if (in_array($v, $allowed, true)) return $v;

            // kalau masih pakai huruf besar kecil atau ada variasi kecil
            foreach ($allowed as $a) {
                if (str_contains($v, $a)) return $a;
            }
            return null;
        };

        while (($data = fgetcsv($handle)) !== false) {
        $data = $parseRow($data);
        if (!$data) continue;


            $line++;

            // Skip baris kosong total
            if (count(array_filter($data, fn($x) => trim((string)$x) !== '')) === 0) {
                continue;
            }

            // gabungkan jadi associative
            $row = [];
            foreach ($header as $i => $key) {
                $row[$key] = $data[$i] ?? null;
            }

            $name = trim((string) ($row['name'] ?? ''));
            $address = trim((string) ($row['address'] ?? ''));
            $lat = $row['latitude'] ?? null;
            $lng = $row['longitude'] ?? null;

            $type = $mapType($row['type'] ?? null);
            $segment = $mapSegment($row[$segmentKey] ?? null);

            // Validasi per baris (ringkas tapi jelas)
            $rowErrors = [];
            if ($name === '') $rowErrors[] = 'name kosong';
            if ($address === '') $rowErrors[] = 'address kosong';
            if (!is_numeric($lat)) $rowErrors[] = 'latitude bukan angka';
            if (!is_numeric($lng)) $rowErrors[] = 'longitude bukan angka';
            if (!$type) $rowErrors[] = 'type tidak valid';
            if (!$segment) $rowErrors[] = 'segment tidak valid';

            if (!empty($rowErrors)) {
                $errors[] = [
                    'line' => $line,
                    'errors' => $rowErrors,
                ];
                continue;
            }

            $rowsToInsert[] = [
                'user_id' => $request->user()->id,
                'name' => $name,
                'address' => $address,
                'latitude' => (float) $lat,
                'longitude' => (float) $lng,
                'type' => $type,
                'segment' => $segment,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        fclose($handle);

        if (count($rowsToInsert) === 0) {
            return response()->json([
                'message' => 'Tidak ada baris valid yang bisa diimport.',
                'inserted' => 0,
                'failed' => count($errors),
                'errors' => array_slice($errors, 0, 15),
            ], 422);
        }

        DB::transaction(function () use ($rowsToInsert) {
            Location::insert($rowsToInsert);
        });

        return response()->json([
            'message' => 'Import CSV berhasil. Data masuk sebagai pending dan menunggu verifikasi admin.',
            'inserted' => count($rowsToInsert),
            'failed' => count($errors),
            'errors' => array_slice($errors, 0, 15), // batasi biar respons tidak kepanjangan
        ], 201);
    }

    public function demografi()
    {
        // Semua data approved
        $approved = DB::table('locations')
            ->where('status', 'approved');

        // Total per type (customer vs non_customer)
        $byType = (clone $approved)
            ->select('type', DB::raw('COUNT(*) as total'))
            ->groupBy('type')
            ->pluck('total', 'type');

        // Total per segment (gabungan semua type)
// Segment distribution - CUSTOMER
        $segmentCustomer = DB::table('locations')
            ->select('segment', DB::raw('COUNT(*) as total'))
            ->where('status', 'approved')
            ->where('type', 'customer')
            ->groupBy('segment')
            ->orderBy('segment')
            ->pluck('total', 'segment');

        // Segment distribution - NON CUSTOMER
        $segmentNonCustomer = DB::table('locations')
            ->select('segment', DB::raw('COUNT(*) as total'))
            ->where('status', 'approved')
            ->where('type', 'non_customer')
            ->groupBy('segment')
            ->orderBy('segment')
            ->pluck('total', 'segment');        

        $dominantCustomerSegment = $segmentCustomer->sortDesc()->keys()->first();
        $dominantNonCustomerSegment = $segmentNonCustomer->sortDesc()->keys()->first();


        $customerTotal = DB::table('locations')
            ->where('status', 'approved')
            ->where('type', 'customer')
            ->count();

        $nonCustomerTotal = DB::table('locations')
            ->where('status', 'approved')
            ->where('type', 'non_customer')
            ->count();


        return view('demografi', [
            'byType' => $byType,
            'customerTotal' => $customerTotal,
            'nonCustomerTotal' => $nonCustomerTotal,
            'segmentCustomer' => $segmentCustomer,
            'segmentNonCustomer' => $segmentNonCustomer,
            'dominantCustomerSegment' => $dominantCustomerSegment,
            'dominantNonCustomerSegment' => $dominantNonCustomerSegment,
        ]);
    }

        public function analytics()
    {
        // Total data approved
        $totalCustomer = DB::table('locations')
            ->where('status', 'approved')
            ->where('type', 'customer')
            ->count();

        $totalNonCustomer = DB::table('locations')
            ->where('status', 'approved')
            ->where('type', 'non_customer')
            ->count();

        $totalAll = $totalCustomer + $totalNonCustomer;

        // Analisis per segmen & type
        $segmentAnalytics = DB::table('locations')
            ->select(
                'segment',
                DB::raw("SUM(CASE WHEN type = 'customer' THEN 1 ELSE 0 END) as customer"),
                DB::raw("SUM(CASE WHEN type = 'non_customer' THEN 1 ELSE 0 END) as non_customer")
            )
            ->where('status', 'approved')
            ->groupBy('segment')
            ->orderBy('segment')
            ->get();

        return view('analytics', compact(
            'totalCustomer',
            'totalNonCustomer',
            'totalAll',
            'segmentAnalytics'
        ));
    }

    public function downloadAnalyticsSegment(Request $request)
{
    $type = $request->query('type');       // customer / non_customer
    $segment = $request->query('segment'); // shop/school/hotel/dll

    // Validasi sederhana (biar aman)
    if (!in_array($type, ['customer', 'non_customer'], true)) {
        abort(400, 'Invalid type.');
    }

    if (!$segment) {
        abort(400, 'Segment is required.');
    }

    // Ambil data approved saja
    $rows = Location::query()
        ->select('name', 'address', 'latitude', 'longitude', 'type', 'segment', 'created_at')
        ->where('status', 'approved')
        ->where('type', $type)
        ->where('segment', $segment)
        ->orderByDesc('created_at')
        ->get();

    $filename = "analytics_{$type}_{$segment}_" . now()->format('Ymd_His') . ".csv";

    return response()->streamDownload(function () use ($rows) {
        $handle = fopen('php://output', 'w');

        // Header CSV
        fputcsv($handle, ['name', 'address', 'latitude', 'longitude', 'type', 'segment', 'created_at']);

        // Isi data
        foreach ($rows as $r) {
            fputcsv($handle, [
                $r->name,
                $r->address,
                $r->latitude,
                $r->longitude,
                $r->type,
                $r->segment,
                optional($r->created_at)->toDateTimeString(),
            ]);
        }

        fclose($handle);
    }, $filename, [
        'Content-Type' => 'text/csv; charset=UTF-8',
    ]);
}



}
