<?php


namespace App\Scoping\Traits;


use App\Scoping\Scoper;
use Illuminate\Database\Eloquent\Builder;

trait CanBeScoped
{
    public function scopeWithScopes(Builder $builder, array $scopes = []): Builder
    {
        return (new Scoper(request()))->apply($builder, $scopes);
    }
}
