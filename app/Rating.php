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

    public function students()
    {
        return $this->belongsToMany(Student::class, 'points');
    }

    public function uniqueStudents()
    {
        return $this->belongsToMany(Student::class, 'points')->get()->unique('name');
    }

    public function getNameAttribute()
    {
        $name = 'Рейтинг за ';

        $name .= $this->type == 'monthly' ? getRussianMonth($this->date) . ' ' . $this->date->year : ' ' . $this->date->year . ' год';

        return $name;
    }

    public function getUrlAttribute()
    {
        return route('rating.show', compact('this'));
    }
}
