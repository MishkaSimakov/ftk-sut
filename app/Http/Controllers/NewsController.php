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
        $this->middleware('admin')->except('index', 'show');
    }

    public function index()
    {
        return response()->json(
            NewsIndexResource::collection(
                News::all()->sortByDesc('date')
            )
        );
    }

    public function show(News $news)
    {
        return response()->json(
            NewsIndexResource::make($news)
        );
    }

    public function store(StoreNewsRequest $request)
    {
        $news = News::create(
            $request->only(['title', 'body', 'date'])
        );
        $news->clubs()->sync($request->get('clubs'));

        return response('OK', 200);
    }

    public function destroy(News $news)
    {
        $news->delete();

        return response('OK', 200);
    }

    public function update(StoreNewsRequest $request, News $news)
    {
        $news->update($request->except('clubs'));
        $news->clubs()->sync($request->clubs);

        return response('OK', 200);
    }
}
