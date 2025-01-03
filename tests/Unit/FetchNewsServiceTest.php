<?php

namespace Tests\Unit\Services;

use App\Models\News;
use App\Services\FetchNewsService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FetchNewsServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testFetch()
    {
        $newsProviders = [
            'provider1' => [
                'url' => 'https://provider1.com/api/news',
                'date_key' => 'from-date',
                'request_body' => [],
                'response_path' => 'data.news',
                'fields_map' => [
                    'title' => 'news_title',
                    'url' => 'news_url',
                    'published_at' => 'news_date',
                    'type'=>'type',
                    'source_id'=>'source_id'
                ],
                'date_key' => 'published_at',
            ],
        ];

        Http::fake([
            'https://provider1.com/api/news' => Http::response([
                'data' => [
                    'news' => [
                        [
                            'news_title' => 'Test News',
                            'news_url' => 'https://test.com',
                            'news_date' => '2025-01-01 10:00:00',
                            'type'=>'type',
                            'source_id'=>'jjjjjj'
                        ],
                    ],
                ],
            ], 200),
        ]);

        FetchNewsService::fetch($newsProviders);

        $this->assertDatabaseHas('news', [
            'title' => 'Test News',
            'url' => 'https://test.com',
            'published_at' => '2025-01-01 10:00:00',
        ]);
    }
}
