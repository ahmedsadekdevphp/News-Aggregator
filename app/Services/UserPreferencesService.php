<?php

namespace App\Services;

use App\Models\UserPreference;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class UserPreferencesService
{
    /**
     * Retrieve the preferences of the  user.
     * @return array|null An associative array containing the decoded preferences, or `null` if no preferences are found.
     */
    public static function getPreferences()
    {
        $preferences = UserPreference::where('user_id', Auth::guard('api')->user()->id)->first();

        if (!$preferences) return null;
        return ([
            'preferred_sources' => json_decode($preferences->preferred_sources),
            'preferred_categories' => json_decode($preferences->preferred_categories),
            'preferred_authors' => json_decode($preferences->preferred_authors),
        ]);
    }
    /**
     * Save or update the user's preferences.
     *
     * @param \Illuminate\Http\Request $request The request object containing the user's preferences.
     *
     * @return array An associative array containing the status and message of the operation.
     *         The status will be HTTP_CREATED (201) if the preferences are saved successfully,
     *         or HTTP_INTERNAL_SERVER_ERROR (500) if an error occurs during saving.
     */

    public static function savePreferences($request)
    {
        try {
            UserPreference::updateOrCreate(
                ['user_id' => Auth::guard('api')->user()->id],
                [
                    'preferred_sources' => json_encode($request->preferred_sources, true),
                    'preferred_categories' => json_encode($request->preferred_categories, true),
                    'preferred_authors' => json_encode($request->preferred_authors, true),
                ]
            );
            return
                [
                    'status' => Response::HTTP_CREATED,
                    'message' => trans('preferences.preferences_saved')
                ];
        } catch (\Exception $e) {
            return
                [
                    'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                    'message' => trans('preferences.saving_error')
                ];
        }
    }
}
