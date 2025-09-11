<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'encrypted_name',
        'encrypted_ci_nit',
        'encrypted_address',
        'encrypted_phone',
        'owner_type',
        'status',
        'registration_date',
        'notes'
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
