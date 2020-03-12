<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * @mixin Builder
 */
class Teacher extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $fillable = ['first_name', 'middle_name', 'last_name', 'club_id', 'avatar'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function (Teacher $teacher) {
            $user = User::make();

            $user->name = $teacher->last_name . ' ' . $teacher->first_name;
            $user->register_code = Str::random(6);
            $user->is_admin = true;

            $user->save();

            $teacher->user_id = $user->id;
        });
    }

    public function getFullNameAttribute()
    {
        return implode(" ", [
            $this->last_name,
            $this->first_name,
            $this->middle_name,
        ]);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getUrlAttribute()
    {
        return route('teacher.show', $this);
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
