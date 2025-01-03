<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\LookupService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use  App\Models\UserPreferences;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SavePreferencesRequest;
use App\Services\ResponseService;
use App\Services\UserPreferencesService;

class UserPreferenceController extends Controller
{
    /**
     * Retrieve lookup data for user preferences.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing the lookup data
     *         and an HTTP status code.
     */
    public function getPreferencesLookups()
    {
        $lookups = LookupService::getPreferencesLookups();
        return response()->json([
            'status' => Response::HTTP_OK,
            'data' => $lookups
        ]);
    }

    /**
     * Retrieve and display the  user's preferences.

     * @return \Illuminate\Http\JsonResponse A JSON response containing the user's preferences
     *         and an HTTP status code.
     */
    public function showPreferences()
    {
        $userPreferences = UserPreferencesService::getPreferences();
        return response()->json([
            'status' => Response::HTTP_OK,
            'data' => $userPreferences
        ]);
    }

    /**
     * Save the authenticated user's preferences.
     *
     * @param \App\Http\Requests\SavePreferencesRequest $request The request object
     *        containing the preferences data to be saved.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing the status
     *         and message indicating the result of the save operation.
     */

    public function savePreferences(SavePreferencesRequest $request)
    {
        $response = UserPreferencesService::savePreferences($request);
        return response()->json($response);
    }
}
