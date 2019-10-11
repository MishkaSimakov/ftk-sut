<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    static public function categories() {
        $categories = Category::all();

        $names = collect([]);

        foreach ($categories as $category) {
            $names->put($category->name, $category);
        }

        return $names;
    }
}
