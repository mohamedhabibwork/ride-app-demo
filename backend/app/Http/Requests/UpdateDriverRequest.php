<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDriverRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->isDriver();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'year' => ['required', 'integer', 'between:2010,2024'],
            'make' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'color' => ['required', 'string', 'max:255'],
            'license_plate' => ['required', 'string', 'max:255'],
//            'name' => ['required', 'string', 'max:255'],
        ];
    }
}
