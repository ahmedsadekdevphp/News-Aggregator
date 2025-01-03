<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Models\UserPreference;
use App\Services\UserPreferencesService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserPreferencesServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testgetPreferences()
    {
        $user = User::factory()->create();
        Auth::login($user);
        $preferences = [
            'preferred_sources' => json_encode(['BBC', 'TechCrunch']),
            'preferred_categories' => json_encode(['Politics', 'Technology']),
            'preferred_authors' => json_encode(['John Doe']),
        ];
        UserPreference::create([
            'user_id' => $user->id,
            'preferred_sources' => $preferences['preferred_sources'],
            'preferred_categories' => $preferences['preferred_categories'],
            'preferred_authors' => $preferences['preferred_authors'],
        ]);
        $result = UserPreferencesService::getPreferences();

        $this->assertNotNull($result);
        $this->assertEquals(['BBC', 'TechCrunch'], $result['preferred_sources']);
        $this->assertEquals(['Politics', 'Technology'], $result['preferred_categories']);
        $this->assertEquals(['John Doe'], $result['preferred_authors']);
    }
    public function testgetPreferencesNoFound()
    {        $user = User::factory()->create();
        Auth::login($user);
        $result = UserPreferencesService::getPreferences();
        $this->assertNull($result);
    }

    public function testsaveUserPreferences()
    {
        $user = User::factory()->create();
        Auth::login($user);
        $preferencesData = [
            'preferred_sources' => ['BBC', 'TechCrunch'],
            'preferred_categories' => ['Politics', 'Technology'],
            'preferred_authors' => ['John Doe'],
        ];
        $request = new \Illuminate\Http\Request($preferencesData);
        $result = UserPreferencesService::savePreferences($request);
        $this->assertEquals(Response::HTTP_CREATED, $result['status']);
        $this->assertEquals(trans('preferences.preferences_saved'), $result['message']);
        $preferences = UserPreference::where('user_id', $user->id)->first();
        $this->assertNotNull($preferences);
        $this->assertEquals(json_encode($preferencesData['preferred_sources']), $preferences->preferred_sources);
        $this->assertEquals(json_encode($preferencesData['preferred_categories']), $preferences->preferred_categories);
        $this->assertEquals(json_encode($preferencesData['preferred_authors']), $preferences->preferred_authors);
    }
}
