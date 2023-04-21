<?php

namespace App\Http\Requests;

use App\Models\Trip;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTripRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('create', Trip::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'origin' => ['required', 'array:lat,lng'],
            'origin.lat' => ['required', 'numeric'],
            'origin.lng' => ['required', 'numeric'],
            'destination' => ['required', 'array:lat,lng'],
            'destination.lat' => ['required', 'numeric'],
            'destination.lng' => ['required', 'numeric'],
            'user_location' => ['required', 'array:lat,lng'],
            'user_location.lat' => ['required', 'numeric'],
            'user_location.lng' => ['required', 'numeric'],
            'destination_name' => ['required', 'string', 'max:255'],
            'distance' => ['required', 'numeric', 'min:1'],

        ];
    }
}
