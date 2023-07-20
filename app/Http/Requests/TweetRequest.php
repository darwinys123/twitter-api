<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Arr;

class TweetRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'description' => 'required'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $error_msg = Arr::flatten($errors->messages());
        $response = response()->json([
            'message' => $error_msg
        ], 422);

        throw new HttpResponseException($response);
    }
}
