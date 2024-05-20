<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (!is_numeric($this->perPage)) {
            $this->merge(['perPage'=>10]);
        }

        if (!is_numeric($this->page)) {
            $this->merge(['page'=>0]);
        }

        if (empty($this->sort) || is_null($this->sort)) {
            $this->merge(['sort'=>'desc']);
        }

        if (empty($this->sortColumn) || is_null($this->sortColumn)) {
            $this->merge(['sortColumn'=>'name']);
        }

        // if (empty($this->name) || is_null($this->name)) {
        //     $this->merge(['name'=>'name']);
        // }

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
            //
        ];
    }
}
