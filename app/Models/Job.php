<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Job extends Model
{

    protected $fillable = ['company_id', 'job_category_id', 'job_type_id', 'title', 'description', 'requirements', 'benefits', 'location', 'work_mode', 'salary_min', 'salary_max', 'vacancies', 'deadline', 'status', 'published_at', 'closed_at'];

    protected $casts = [
        "requirements" => "array",
        "benefits" => "array",
    ];

    public function jobCategory() : BelongsTo {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }

    public function jobType() : BelongsTo {
        return $this->belongsTo(JobType::class, "job_type_id");
    }

    public function company() : BelongsTo {
        return $this->belongsTo(Companies::class, "company_id");
    }
}
