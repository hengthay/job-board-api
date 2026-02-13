<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidateProfileRequest extends FormRequest
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
            "title" => "required|string|max:255",
            "summary" => "nullable|string",
            "locatoin" => "nullable|string",
            "experience_years" => "nullable|integer",
            "portfolio_url" => "nullable|url",
            "linkedin_url" => "nullable|url",
            "github_url" => "nullable|url"
        ];
    }
}
