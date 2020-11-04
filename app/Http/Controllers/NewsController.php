<?php

namespace App\Http\Controllers;

use App\Http\Requests\News\StoreNewsRequest;
use App\Http\Resources\News\NewsIndexResource;
use App\Models\Club;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->except('index');
    }

    public function index()
    {
        return response()->json(
            NewsIndexResource::collection(
                News::all()->sortByDesc('date')
            )
        );
    }

    public function store(StoreNewsRequest $request)
    {
        $news = News::create(
            $request->only(['title', 'body', 'date'])
        );
        $news->clubs()->sync($request->get('clubs'));

        return response();
    }
}
