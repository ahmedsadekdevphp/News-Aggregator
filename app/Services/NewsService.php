<?php

namespace App\Services;

use App\Models\News;
use App\Models\UserPreference;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
class NewsService
{
    /**
     * Perform a search query on the News model based on the provided filters.
     *
     * @param \Illuminate\Http\Request $request The request object containing the search filters:
     *      - keyword: (string) A keyword to search for in the news title.
     *      - category: (string) The category to filter the news by.
     *      - source: (string) The source to filter the news by.
     *      - start_date: (string) The start date of the publication date range.
     *      - end_date: (string) The end date of the publication date range.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator Paginated search results.
     */
    public static function search($request)
    {
        $query = News::query();
        if ($request->keyword) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }
        if ($request->category) {
            $query->where('category', $request->category);
        }
        if ($request->source) {
            $query->where('source', $request->source);
        }
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('published_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }
        return $query->orderBY('published_at', 'desc')->paginate(config('news.search_news_pagination'));
    }

    /**
     * Retrieve a personalized news feed based on user preferences.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator A paginated list of news articles
     *         matching the user's preferences, ordered by publication date.
     */
    public static function getNewsFeed($preferences)
    {
        $query = News::query();
        if ($preferences) {
            if ($preferences['preferred_sources']) {
                $query->orwhereIn('source', $preferences['preferred_sources']);
            }
            if ($preferences['preferred_categories']) {
                $query->orwhereIn('category', $preferences['preferred_categories']);
            }
            if ($preferences['preferred_authors']) {
                $query->orwhereIn('author', $preferences['preferred_authors']);
            }
        }
        return  $query->orderBY('published_at', 'desc')->paginate(config('news.news_feed_pagination'));
    }
}
