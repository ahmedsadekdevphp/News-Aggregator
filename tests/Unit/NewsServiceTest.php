<?php

namespace Tests\Unit\Services;

use App\Models\News;
use App\Services\NewsService;
use App\Services\UserPreferencesService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class NewsServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the search method with valid filters.
     *
     * @return void
     */
    public function testSearchWithFilters()
    {
        News::factory()->create([
            'title' => 'Breaking News',
            'category' => 'World',
            'source' => 'BBC',
            'author' => 'John Doe',
            'published_at' => now(),
        ]);
        $request = \Mockery::mock(\Illuminate\Http\Request::class);
        $request->shouldReceive('all')->andReturn([
            'keyword' => 'Breaking',
            'category' => 'World',
            'source' => 'BBC',
            'start_date' => null,
            'end_date' => null,
        ]);
        $results = NewsService::search($request);
        $this->assertEquals(1, $results->total());
        $this->assertEquals('Breaking News', $results->first()->title);
    }

    public function testGetNewsFeedWithPreferences()
    {
        $preferences = [
            'preferred_sources' => ['BBC', 'TechCrunch'],
            'preferred_categories' => ['Politics'],
            'preferred_authors' => ['John Doe'],
        ];
        $newsData = [
            ['title' => 'Breaking News', 'source' => 'BBC', 'category' => 'Politics', 'author' => 'John Doe'],
            ['title' => 'Tech Trends', 'source' => 'TechCrunch', 'category' => 'Technology', 'author' => 'Jane Smith'],
        ];
        foreach ($newsData as $data) {
            News::create($data);
        }
        $newsFeed = NewsService::getNewsFeed($preferences);
        $this->assertCount(2, $newsFeed);
        $this->assertEquals('Breaking News', $newsFeed->first()->title);
    }
}
