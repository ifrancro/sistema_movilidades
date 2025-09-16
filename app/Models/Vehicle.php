<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'plate_number',
        'chassis_number',
        'brand',
        'model',
        'year',
        'color',
        'capacity',
        'vehicle_type',
        'status',
        'owner_id',
        'route_id',
        'driver_id',
        'registration_date',
        'insurance_expiry',
        'technical_inspection_expiry',
        'notes'
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }
}
