<?php

namespace App\Models;

use App\Models\Traits\Publishable;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model implements Viewable
{
    use HasFactory;
    use InteractsWithViews;
    use Publishable;

    protected $fillable = ['title', 'date', 'body'];
    protected $dates = ['date'];
    protected bool $removeViewsOnDelete = true;

    const PAGINATION_LIMIT = 50;
}
