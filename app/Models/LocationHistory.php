<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationHistory extends Model
{
    protected $fillable = [
        'location_id', 'changed_by',
        'old_status', 'new_status',
        'old_type', 'new_type', 'change_type',
        'note',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
