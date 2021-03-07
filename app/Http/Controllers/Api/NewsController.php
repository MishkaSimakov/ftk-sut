<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\News\NewsIndexResource;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $news = News::orderBy('date', $request->query('sortType', 'fresh') == 'fresh' ? 'desc' : 'asc')
            ->paginate(50)->items();

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

