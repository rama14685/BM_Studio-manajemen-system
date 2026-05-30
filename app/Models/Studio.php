<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price_per_hour'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
