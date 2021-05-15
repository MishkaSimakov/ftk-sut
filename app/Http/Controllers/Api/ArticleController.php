<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ArticleSearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ArticleController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('query');

        return response()->json(
            (new ArticleSearchService())->getQueryResults($query)
        );
    }
}
