<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductProp extends Model
{
    use HasFactory;

    protected $fillable = [
      'code',
      'label',
      'product_id',
      'value',
  ];

  protected $hidden = [
      // Inserisci qui gli attributi che vuoi nascondere
  ];

  public function product()
  {
      return $this->belongsTo(Product::class, 'product_id');
  }

}
