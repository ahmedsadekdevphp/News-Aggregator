<?php

namespace App\Services;

use App\Models\News;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class NewsService
{

    public static function getLookups()
    {
        $categories = News::distinct()->pluck('category');
        $sources = News::distinct()->pluck('source');
        return ([
            'categories' => $categories,
            'sources' => $sources,
        ]);
    }

    public static function search($request)
    {
        $query = News::query();
        if ($request->has('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }
        if ($request->has('source') && !empty($request->source)) {
            $query->where('source', $request->source);
        }
        $news = $query->orderBY('published_at', 'desc')->get();
        return  $news;
    }
}
