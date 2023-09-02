<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
    use HasFactory;


    protected $fillable = [
        'main',
        'product_id',
        'url',
        'description',
        'width',
        'height',
  ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
