<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelatedProductView extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'related_products_view';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'product_id', 'related_id', 'title', 'description', 'url', 'rating', 'votes_count'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'product_id' => 'integer',
        'related_id' => 'integer',
        'rating' => 'float',
        'votes_count' => 'integer'
    ];

    // Aggiungi qui eventuali relazioni o metodi personalizzat

}
