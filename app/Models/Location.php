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
    ];

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
}
