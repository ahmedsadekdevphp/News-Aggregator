<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Services\NewsService;
use Illuminate\Http\Response;

class NewsController extends Controller
{
    public function searchFormData()
    {
        $response = NewsService::getLookups();
        return response()->json([
            'status' => Response::HTTP_OK,
            'data' => $response
        ]);
    }


    public function serach(Request $request)
    {
        $news = NewsService::search($request);
        return response()->json([
            'status' => Response::HTTP_OK,
            'data' => $news
        ]);
    }

}
