<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFeedback extends Model
{
    use HasFactory;

    protected $table = 'product_feedback';  // Opzionale, solo se il nome della classe e la tabella non coincidono

    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'comment'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
