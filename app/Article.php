<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Article extends Model
{
    //

    protected $guarded = [];

    public function getPublishAttribute() {
    	return route('article.publish', compact('this'));
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_likes');
    }

    public function getDeleteAttribute() {
    	return route('article.destroy', compact('this'));
    }

    public function getUserAttribute() {
    	return User::where('id', $this->user_id)->first();
    }

    public function getIsLikedAttribute() {
        return UserLike::where([['article_id', $this->id], ['user_id', Auth::user()->id]])->exists();
    }
}
