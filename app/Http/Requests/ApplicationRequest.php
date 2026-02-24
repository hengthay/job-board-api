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
        if ($this->isMethod('post')) {
            return [
                'job_id' => 'required|integer|exists:jobs,id',
                'resume_id' => 'required|integer|exists:resumes,id',
                'cover_letter' => 'nullable|string',
            ];
        }

        // update (PUT/PATCH)
        return [
            'cover_letter' => 'sometimes|nullable|string',
            'status' => 'sometimes|string',
            'reviewed_at' => 'sometimes|date',
            'employer_note' => 'sometimes|nullable|string',
        ];
    }
}
