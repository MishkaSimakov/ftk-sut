<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RatingPointCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'color', 'name', 'slug', 'order'
    ];

    public function importNames(): HasMany
    {
        return $this->hasMany(RatingPointCategoryImportName::class, 'category_id', 'id');
    }
}
