<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompaniesRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "user_id" => "required|integer",
            "name" => "required|string",
            "slug" => "nullable|string",
            "logo_path" => "nullable|image|mimes:jpg,jpeg,png,svg|max:2048",
            "website_url" => "nullable|url",
            "industry" => "required|string",
            "company_size" => "nullable|string",
            "location" => "nullable|string",
            "description" => "nullable|string",
            "verified_at" => "nullable|date"
        ];
    }
}
