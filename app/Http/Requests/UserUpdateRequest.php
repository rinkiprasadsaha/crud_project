<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Exceptions\HttpResponseException;
class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->merge([
            "password" => Hash::make($this->password),
        ]);

        return true;
    }


    public function rules(): array
    {
        return[
            "email" => "regex:/(.+)@(.+)\.(.+)/i|unique:users,email," . $this->id ?? 0,
            "password" => "min:8",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
