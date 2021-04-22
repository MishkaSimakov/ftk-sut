<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ArticleSearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ArticleController extends Controller
{
    public ArticleSearchService $articleSearchService;
    public function __construct(ArticleSearchService $articleSearchService)
    {
        $this->articleSearchService = $articleSearchService;
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->get('query');

        return response()->json(
            $this->articleSearchService->getQueryResults($query)
        );
    }
}
