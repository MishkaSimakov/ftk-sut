<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\News\NewsIndexResource;
use App\Models\News;
use CyrildeWit\EloquentViewable\Support\Period;
use CyrildeWit\EloquentViewable\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $news = News::orderBy('date', $request->query('sortType', 'fresh') == 'fresh' ? 'desc' : 'asc')
            ->paginate(News::PAGINATION_LIMIT)->items();

        foreach ($news as $n) {
            views($n)->cooldown(now()->addHours(3))->record();
        }

        return response()->json(
            NewsIndexResource::collection(
                $news
            )
        );
    }

    public function show(News $news)
    {
        return response()->json(
            NewsIndexResource::make($news)
        );
    }
}

