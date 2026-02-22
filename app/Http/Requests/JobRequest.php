<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
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
            "company_id" => "required|integer",
            "job_category_id" => "required|integer",
            "job_type_id" => "required|integer",
            "title" => "required|string",
            "description" => "nullable|string",
            "requirements" => "nullable|array",
            "benefits" => "nullable|array",
            "location" => "nullable|string",
            "work_mode" => "required|string",
            "salary_min" => "nullable|numeric|min:0",
            "salary_max" => "nullable|numeric|gte:salary_min",
            "vacancies" => "required|integer",
            "deadline" => "required|date",
            "status" => "sometimes|string",
            "published_at" => "nullable|date",
            "closed_at" => "nullable|date|after_or_equal:published_at",
        ]; 
    }
}
