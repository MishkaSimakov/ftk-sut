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
            switch ($this->date->month) {
                case(1):
                    $name .= 'Январь';
                break;
                case(2):
                    $name .= 'Февраль';
                break;
                case(3):
                    $name .= 'Март';
                break;
                case(4):
                    $name .= 'Арпель';
                break;
                case(5):
                    $name .= 'Май';
                break;
                case(6):
                    $name .= 'Июнь';
                break;
                case(7):
                    $name .= 'Июль';
                break;
                case(8):
                    $name .= 'Август';
                break;
                case(9):
                    $name .= 'Сентябрь';
                break;
                case(10):
                    $name .= 'Октябрь';
                break;
                case(11):
                    $name .= 'Ноябрь';
                break;
                case(12):
                    $name .= 'Декабрь';
                break;
            }

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
