<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //

    protected $fillable = ['isPublished'];

    public function getPublishAttribute() {
    	return route('article.publish', compact('this'));
    }

    public function getDeleteAttribute() {
    	return route('article.destroy', compact('this'));
    }

    public function getUserAttribute() {
    	return User::where('id', $this->user_id)->first();
    }
}
