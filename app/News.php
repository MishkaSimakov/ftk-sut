<?php

namespace App;

use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Model;

class News extends Model implements Viewable
{
    use InteractsWithViews;

    protected $table = 'news';

    protected $fillable = ['title', 'body'];
}
