<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $fillable = [
      'id_parent',
      'code',
      'label',
      'description',
    ];

    // Definisci la relazione uno-a-molti con le sottocategorie
    public function subcategories()
    {
        return $this->hasMany(Category::class, 'id_parent');
    }

    // Definisci la relazione molti-a-uno con la categoria genitore
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'id_parent');
    }
}