<?php


namespace App\Scoping\Scopes\Articles;


use App\Scoping\Contracts\Scope;
use Illuminate\Database\Eloquent\Builder;

class AuthorScope implements Scope
{
    public function apply(Builder $builder, $value): Builder
    {
        return $builder->whereHas('author', function (Builder $builder) use ($value) {
            return $builder->where('name', $value);
        });
    }
}
