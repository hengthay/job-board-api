<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
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
            "job_id" => "required|integer",
            "user_id" => "required|integer",
            "resume_id" => "required|integer",
            "cover_letter" => "nullable|string",
            "status" => "nullable|string",
            "applied_at" => "nullable|date",
            "reviewd_at" => "nullable|date",
            "employer_note" => "nullable|string"
        ];
    }
}
