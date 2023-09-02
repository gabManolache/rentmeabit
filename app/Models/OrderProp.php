<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProp extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'key',
        'value'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
