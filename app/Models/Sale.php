<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subtotal',
        'iva',
        'total'
    ];

    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }
}
