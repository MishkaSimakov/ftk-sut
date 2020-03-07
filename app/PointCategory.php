<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


/**
 * @mixin Builder
 */
class PointCategory extends Model
{
    static public function categories() {
        $categories = PointCategory::all();

        $names = collect([]);

        foreach ($categories as $category) {
            $names->put($category->name, $category);
        }

        return $names;
    }
}
