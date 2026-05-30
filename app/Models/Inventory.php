<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'stock_qty',
        'price',
        'condition'
    ];

    public function posItems()
    {
        return $this->hasMany(PosItem::class);
    }
}
