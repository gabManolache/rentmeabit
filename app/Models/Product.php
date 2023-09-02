<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title', 'status', 'rents', 'description', 'price', 'user_id', 'category',
        'created_by', 'created_at', 'updated_by', 'updated_at', 'deleted_at', 'deleted'
    ];

    protected $hidden = [
        'created_by', 'updated_by', 'deleted'
    ];

    public function properties()
    {
        return $this->hasMany(ProductProp::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(ProductPhoto::class, 'product_id');
    }

    public function wishLists()
    {
        return $this->hasMany(WishList::class, 'product_id');
    }

    public function rents()
    {
        return $this->hasMany(OrderProduct::class, 'product_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(ProductFeedback::class, 'product_id');
    }


}
