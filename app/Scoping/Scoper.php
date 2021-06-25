<?php


namespace App\Scoping;


use App\Scoping\Contracts\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Scoper
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder, array $scopes): Builder
    {
        foreach ($scopes as $key => $scope) {
            if (!$this->request->has($key) or !$scope instanceof Scope) {
                continue;
            }

            $builder = $scope->apply($builder, $this->request->get($key));
        }

        return $builder;
    }
}
