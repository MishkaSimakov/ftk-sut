<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'date', 'body'];
    protected $dates = ['date'];

    public function clubs()
    {
        return $this->belongsToMany(Club::class, 'news_club');
    }

    public function scopeClub(Builder $builder, $club)
    {
        if ($club instanceof Club) {
            $club = $club->name;
        }

        return $builder->whereHas('clubs', function (Builder $builder) use ($club) {
            $builder->where('name', $club);
        });
    }
}