<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


/**
 * @mixin Builder
 */
class Rating extends Model
{
    protected $fillable = ['date'];
    protected $dates = ['created_at', 'updated_at', 'date'];

    public function points()
    {
        return $this->hasMany(Point::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'points')->distinct();
    }

    public function getNameAttribute()
    {
        return $this->date->locale('ru')->isoFormat($this->type == 'monthly' ? 'Рейтинг за MMMM YYYY' : 'Рейтинг за YYYY год');
    }

    public function getUrlAttribute()
    {
        return route('rating.show', $this);
    }
}
