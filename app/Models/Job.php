<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = ['company_id', 'job_category_id', 'job_type_id', 'title', 'description', 'requirements', 'benefits', 'location', 'work_mode', 'salary_min', 'salary_max', 'vacancies', 'deadline', 'status', 'published_at', 'closed_at'];

    protected $casts = [
        "requirements" => "array",
        "benefits" => "array",
    ];
}
