<?php

namespace Tests\Unit\Services;

use App\Models\News;
use App\Services\LookupService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Mockery;
use Tests\TestCase;

class LookupServiceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test the getSources method with caching.
     *
     * @return void
     */
    public function testGetSources()
    {
        $expectedSources = ['ntimes', 'gurdian'];
        Cache::shouldReceive('remember')
            ->once()
            ->with('sources', config('news.cache_expiration_time'), Mockery::type('Closure'))
            ->andReturn($expectedSources);
        $sources = LookupService::getSources();
        $this->assertEquals($expectedSources, $sources);
    }

    /**
     * Test the getCategories method with caching.
     *
     * @return void
     */
    public function testGetCategories()
    {
        $expectedCategories = ['world', 'news'];
        Cache::shouldReceive('remember')
            ->once()
            ->with('categories', config('news.cache_expiration_time'), Mockery::type('Closure'))
            ->andReturn($expectedCategories);
        $categories = LookupService::getCategories();
        $this->assertEquals($expectedCategories, $categories);
    }

    /**
     * Test the getAuthors method with caching.
     *
     * @return void
     */
    public function testGetAuthors()
    {
        $expectedAuthors = ['Ahmed', 'sadek'];
        Cache::shouldReceive('remember')
            ->once()
            ->with('authors', config('news.cache_expiration_time'), Mockery::type('Closure'))
            ->andReturn($expectedAuthors);
        $authors = LookupService::getAuthors();
        $this->assertEquals($expectedAuthors, $authors);
    }

    /**
     * Test the getPreferencesLookups method which calls getCategories, getSources, and getAuthors.
     *
     * @return void
     */
    public function testGetPreferencesLookups()
    {
        $expectedSources = ['ntimes', 'gurdian'];
        $expectedCategories = ['world', 'news'];
        $expectedAuthors = ['Ahmed', 'sadek'];

        Cache::put('sources', $expectedSources, config('news.cache_expiration_time'));
        Cache::put('categories', $expectedCategories, config('news.cache_expiration_time'));
        Cache::put('authors', $expectedAuthors, config('news.cache_expiration_time'));

        $preferences = LookupService::getPreferencesLookups();

        $this->assertEquals([
            'categories' => $expectedCategories,
            'sources' => $expectedSources,
            'authors' => $expectedAuthors,
        ], $preferences);
    }

    /**
     * Test the getSearchLookups method which calls getCategories and getSources.
     *
     * @return void
     */
    public function testGetSearchLookups()
    {
        $expectedSources = ['ntimes', 'gurdian'];
        $expectedCategories = ['world', 'news'];

        Cache::put('categories', $expectedCategories, config('news.cache_expiration_time'));
        Cache::put('sources', $expectedSources, config('news.cache_expiration_time'));

        $searchLookups = LookupService::getSearchLookups();

        $this->assertEquals([
            'categories' => $expectedCategories,
            'sources' => $expectedSources,
        ], $searchLookups);
    }
}
