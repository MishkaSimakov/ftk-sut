<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['date'];
    protected $dates = ['created_at', 'updated_at', 'date'];

    public function points()
    {
        return $this->hasMany(Point::class);
    }

    public function getNameAttribute()
    {
        $name = 'Рейтинг за ';

        if ($this->isMonthly) {
            $name .= getRussianMonth($this->date);

            $name .= ' ' . $this->date->year;
        } else {
            $name .= ' ' . $this->date->year . ' год'; 
        }

        return $name;
    }

    public function getUrlAttribute()
    {
        return route('rating.show', compact('this'));
    }
}
