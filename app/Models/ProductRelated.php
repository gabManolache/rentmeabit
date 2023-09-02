<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductRelated extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'product_id',
        'created_by', 'created_at', 'updated_by', 'updated_at', 'deleted_at', 'deleted'
    ];

    protected $hidden = [
        'created_by', 'updated_by', 'deleted'
    ];

    protected $dates = ['deleted_at'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function related()
    {
        return $this->belongsTo(Product::class, 'related_id');
    }
}
