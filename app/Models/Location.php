<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'owner_name',
        'phone',
        'business_detail',
        'omset',
        'paket_langganan',
        'address',
        'latitude',
        'longitude',
        'type',
        'segment',
        'status',
        'is_potential',
    ];

    protected $casts = [
        'is_potential' => 'boolean',
    ];

    public function histories()
    {
        return $this->hasMany(LocationHistory::class)
                    ->latest()
                    ->with('user:id,name');
    }

    public static function omsetLabel(): array
    {
        return [
            'di_bawah_5jt'  => 'Di Bawah Rp 5 Juta',
            '5jt_20jt'      => 'Rp 5 Juta – Rp 20 Juta',
            '20jt_50jt'     => 'Rp 20 Juta – Rp 50 Juta',
            '50jt_100jt'    => 'Rp 50 Juta – Rp 100 Juta',
            'di_atas_100jt' => 'Di Atas Rp 100 Juta',
        ];
    }

    public function getCheckFlags(): array
    {
        $flags = [];

        // 1. Nama tidak wajar
        $nameClean = trim($this->name);
        $hasLetters = preg_match('/[a-zA-Z]{3,}/', $nameClean);
        if (strlen($nameClean) < 3 || !$hasLetters) {
            $flags[] = [
                'type'  => 'nama_tidak_wajar',
                'label' => 'Nama bisnis tidak wajar',
            ];
        }

        // 2. Duplikat dengan data approved lain (Haversine, radius 50m, nama mirip)
        $duplicates = self::where('status', 'approved')
            ->where('id', '!=', $this->id)
            ->where('name', 'LIKE', '%' . $nameClean . '%')
            ->get()
            ->filter(function ($loc) {
                $R    = 6371000;
                $dLat = deg2rad($loc->latitude  - $this->latitude);
                $dLng = deg2rad($loc->longitude - $this->longitude);
                $a    = sin($dLat / 2) * sin($dLat / 2)
                      + cos(deg2rad($this->latitude)) * cos(deg2rad($loc->latitude))
                      * sin($dLng / 2) * sin($dLng / 2);
                $dist = $R * 2 * atan2(sqrt($a), sqrt(1 - $a));
                return $dist < 50;
            });

        if ($duplicates->count() > 0) {
            $flags[] = [
                'type'   => 'duplikat',
                'label'  => 'Terdeteksi mirip dengan data lain',
                'detail' => $duplicates->first()->name,
            ];
        }

        // 3. Koordinat di luar area Kota Jambi (backend only — tidak tampil di UI)
        $outOfBounds = (
            $this->latitude  < -1.70 || $this->latitude  > -1.50 ||
            $this->longitude < 103.55 || $this->longitude > 103.70
        );
        if ($outOfBounds) {
            $flags[] = [
                'type'          => 'luar_area',
                'label'         => 'Lokasi di luar area yang diharapkan',
                'hidden_detail' => true,
            ];
        }

        return $flags;
    }

    public function getIncompleteFields(): array
    {
        $incomplete = [];
        if (empty($this->owner_name))      $incomplete[] = 'Nama Pemilik';
        if (empty($this->phone))           $incomplete[] = 'No. Telepon';
        if (empty($this->business_detail)) $incomplete[] = 'Bidang Bisnis';
        if (empty($this->omset))           $incomplete[] = 'Omset';
        return $incomplete;
    }
}
