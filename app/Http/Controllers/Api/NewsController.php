<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Services\LookupService;
use App\Services\NewsService;
use Illuminate\Http\Response;
use App\Services\UserPreferencesService;
class NewsController extends Controller
{
    /**
     * Retrieve search form Lookups data for filtering options.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing the status
     *         and the lookup data for the search form.
     */

    public function searchFormData()
    {
        $response = LookupService::getSearchLookups();
        return response()->json([
            'status' => Response::HTTP_OK,
            'data' => $response
        ]);
    }

    /**
     * Perform a search for news based on the user's request filters.
     *
     * @param \Illuminate\Http\Request $request The request object containing search filters.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing the search results
     *         (news) and an HTTP status code.
     */

    public function search(Request $request)
    {
        $news = NewsService::search($request);
        return response()->json([
            'status' => Response::HTTP_OK,
            'news' => $news
        ]);
    }

    /**
     * Retrieve the news feed based on user preferences.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing the news feed
     *         and an HTTP status code.
     */
    public function newsFeed()
    {
        $preferences = UserPreferencesService::getPreferences();
        $news = NewsService::getNewsFeed($preferences);
        return response()->json([
            'status' => Response::HTTP_OK,
            'news' => $news
        ]);
    }
}
