<?php

namespace App\Http\Requests;

use App\Rules\CharacterLimitZipCodeRule;
use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'zip_code' => [
                'required',
                'numeric',
                new CharacterLimitZipCodeRule
            ],
            'house_number' => 'required|numeric',
            'complement' => 'string'
        ];
    }

    public function messages(): array
    {
        return [
            'house_number.required' => 'house_number required.',
        ];
    }
}
