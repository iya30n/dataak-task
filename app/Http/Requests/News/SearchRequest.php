<?php

namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class SearchRequest extends FormRequest
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
            "start_date" => ["required_without_all:title,resource,user", "date_format:Y-m-d"],
            "end_date" => ["nullable", "date_format:Y-m-d"],
            "title" => ["required_without_all:start_date,resource,user", "string", "min:2", "max:70"],
            "resource" => ["required_without_all:start_date,title,user", "string", "min:2", "max:50"],
            "user" => ["required_without_all:start_date,title,resource", "string", "min:2", "max:50"],
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json(['errors' => \Arr::collapse($errors)], 422)
        );
    }
}
