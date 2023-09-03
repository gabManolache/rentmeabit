<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
      'parent_id',
      'code',
      'label',
      'description',
    ];

    // Definisci la relazione uno-a-molti con le sottocategorie
    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Definisci la relazione molti-a-uno con la categoria genitore
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
