<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_point',
        'end_point',
        'distance',
        'estimated_time',
        'status'
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function stops()
    {
        return $this->belongsToMany(Stop::class, 'route_stops')
            ->withPivot('order', 'estimated_time')
            ->orderBy('route_stops.order');
    }

    public function coordinates()
    {
        return $this->hasMany(RouteCoordinate::class);
    }
}
