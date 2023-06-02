<?php

namespace App\Http\Requests\Twitter;

use Illuminate\Foundation\Http\FormRequest;

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
            "start_date" => ["required_without_all:content,resource,user", "date_format:Y-m-d"],
            "end_date" => ["nullable", "date_format:Y-m-d"],
            "content" => ["required_without_all:start_date,resource,user", "string", "min:2", "max:70"],
            "resource" => ["required_without_all:start_date,content,user", "string", "min:2", "max:50"],
            "user" => ["required_without_all:start_date,content,resource", "string", "min:2", "max:50"],
        ];
    }
}
