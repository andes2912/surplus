<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoryProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        if($this->method() == 'POST') {
            return [
                'category_id'   => ["required","integer", Rule::exists('categories','id')],
                'product_id'    => ["required","integer", Rule::exists('products','id')],
            ];
        }

        return [
            'category_id'   => ["integer", Rule::exists('categories','id')],
            'product_id'    => ["integer", Rule::exists('products','id')],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'code'      => (int) 422,
                'message'   => (string) config('code.'. 422, "The given data was invalid."),
                'data'      => $validator->errors(),
                'error'     => null
            ], 422)
        );
    }
}
