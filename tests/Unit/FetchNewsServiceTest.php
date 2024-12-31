<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use App\Services\FetchNewsService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use App\Models\News;

class FetchNewsServiceTest extends TestCase
{
    use RefreshDatabase;
    public function testFetch()
    {
        $newsProviders = [
            'provider1' => [
                'url' => 'http://example.com/api/news',
                'request_body' => ['key' => 'value'],
                'response_path' => 'data',
                'date_key' => 'date',
                'fields_map' => [
                    'title' => 'title',
                    'url' => 'url',
                    'published_at' => 'published_at',
                ],
            ],
        ];

        Http::fake([
            'http://example.com/api/news' => Http::response([
                'data' => [
                    [
                        'title' => 'Test News',
                        'url' => 'http://example.com',
                        'published_at' => now()->toDateTimeString()
                    ]
                ]
            ], 200)
        ]);
        FetchNewsService::fetch($newsProviders);
    }
}
