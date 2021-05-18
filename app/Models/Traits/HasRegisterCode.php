<?php


namespace App\Models\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasRegisterCode
{
    protected static function boot()
    {
        parent::boot();

        static::saving(function (Model $model) {
            if (!$model->register_code) {
                $model->register_code = Str::random(6);
            }
        });
    }
}
