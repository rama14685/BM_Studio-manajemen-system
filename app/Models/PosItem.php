<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'pos_transaction_id',
        'inventory_id',
        'qty',
        'subtotal'
    ];

    public function posTransaction()
    {
        return $this->belongsTo(PosTransaction::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
