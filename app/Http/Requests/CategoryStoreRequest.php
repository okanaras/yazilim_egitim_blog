<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
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
            'name' => ['required', 'max:255'],
            'slug' => ['max:255'],
            'description' => ['max:255'],
            'seo_keywords' => ['max:255'],
            'seo_description' => ['max:255'],
            'image' => ['image', 'mimes:png,jpg,jpeg', 'nullable']

        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Kategori adi alani zorunludur.",
            'name.max' => "Kategori adi alani en fazla 255 karakterden olusabilir.",
            'description.max' => "Kategori aciklama alani en fazla 255 karakterden olusabilir.",
            'seo_keywords.max' => "Kategori Seo Keywords adi alani en fazla 255 karakterden olusabilir.",
            'seo_description.max' => "Kategori Seo Description adi alani en fazla 255 karakterden olusabilir.",
        ];
    }
}