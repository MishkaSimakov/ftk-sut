<?php


namespace App\Scoping\Scopes\Articles;


use App\Scoping\Contracts\Scope;
use Illuminate\Database\Eloquent\Builder;

class TagScope implements Scope
{
    public function apply(Builder $builder, $value): Builder
    {
        return $builder->whereHas('tags', function (Builder $builder) use ($value) {
            return $builder->where('name', $value);
        });
    }
}
