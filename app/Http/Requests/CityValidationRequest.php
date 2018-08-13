<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CityValidationRequest extends FormRequest
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
    public function rules()
    {
        return [
            'city_id' => 'required|exists:geoname,geonameid',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'city_id.required'  => 'City is required field',
            'city_id.exists'    => 'City not exist'
        ];
    }
}
