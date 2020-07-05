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

    public function getYearAttribute()
    {
        return $this->date->isoFormat('YYYY');
    }

    public function getAcademicYearAttribute()
    {
        if ($this->type === 'yearly') {
            return ($this->year - 1) . '-' . $this->year;
        }

        if ($this->date->isoFormat('MM') < 9) {
            return ($this->year - 1) . '-' . $this->year;
        } else {
            return $this->year . '-' . ($this->year + 1);
        }
    }

    public function getNameAttribute()
    {
        return $this->type == 'monthly' ?
                'Рейтинг за ' . $this->date->locale('ru')->isoFormat('MMMM YYYY') :
                'Рейтинг за '. $this->academicYear . ' гг.';
    }

    public function getUrlAttribute()
    {
        return route('rating.show', $this);
    }
}
