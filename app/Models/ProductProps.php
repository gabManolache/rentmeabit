<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductProps extends Model
{
    use HasFactory;

    protected $fillable = [
      'code',
      'label',
      'id_product',
      'value',
  ];

  protected $hidden = [
      // Inserisci qui gli attributi che vuoi nascondere
  ];

  public function product()
  {
      return $this->belongsTo(Product::class, 'id_product');
  }

}