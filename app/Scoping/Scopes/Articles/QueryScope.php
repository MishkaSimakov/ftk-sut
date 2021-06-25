<?php


namespace App\Scoping\Scopes\Articles;


use App\Scoping\Contracts\Scope;
use Illuminate\Database\Eloquent\Builder;

class QueryScope implements Scope
{
    public function apply(Builder $builder, $value): Builder
    {
        return $builder->where('title', 'like', "%{$value}%")
            ->orWhere('body', 'like', "%{$value}%")
            ->orWhereHas('author', function (Builder $builder) use ($value) {
                return $builder->where('name', 'like', "%{$value}%");
            })
            ->orWhereHas('tags', function (Builder $builder) use ($value) {
                return $builder->where('name', 'like', "%{$value}%");
            });
    }
}
