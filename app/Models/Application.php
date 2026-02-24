<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    protected $fillable = ['job_id', 'user_id', 'resume_id', 'cover_letter', 'status', 'applied_at', 'reviewed_at', 'employer_note'];

    public function job() : BelongsTo {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function resume() : BelongsTo {
        return $this->belongsTo(Resumes::class, 'resume_id');
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
}
