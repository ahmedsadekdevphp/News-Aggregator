<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavePreferencesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'preferred_sources' => 'nullable|array',
            'preferred_sources.*' => 'string',
            'preferred_categories' => 'nullable|array',
            'preferred_categories.*' => 'string',
            'preferred_authors' => 'nullable|array',
            'preferred_authors.*' => 'string',
        ];
    }
    public function messages(): array
    {
        return [
            'preferred_sources.array' => trans('preferences.preferred_sources.array'),
            'preferred_sources.*.string' => trans('preferences.preferred_sources.string'),

            'preferred_categories.array' => trans('preferences.preferred_categories.array'),
            'preferred_categories.*.string' => trans('preferences.preferred_categories.string'),

            'preferred_authors.array' => trans('preferences.preferred_authors.array'),
            'preferred_authors.*.string' => trans('preferences.preferred_authors.string'),
        ];
    }
}
