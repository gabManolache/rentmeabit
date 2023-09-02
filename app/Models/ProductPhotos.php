<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPhotos extends Model
{
    use HasFactory;


    protected $fillable = [
      'id_product',
      'url',
      'description',
      'width',
      'height',
  ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
}