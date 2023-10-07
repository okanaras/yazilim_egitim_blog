<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleFilterRequest extends FormRequest
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
        return [
            'min_view_count' => ['integer', "nullable"],
            'max_view_count' => ['integer', "nullable"],
            'min_like_count' => ['integer', "nullable"],
            'max_like_count' => ['integer', "nullable"]
        ];
    }
}