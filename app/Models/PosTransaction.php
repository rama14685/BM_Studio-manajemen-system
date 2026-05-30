<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'total_amount',
        'payment_method'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function posItems()
    {
        return $this->hasMany(PosItem::class);
    }
}
