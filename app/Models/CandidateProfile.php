<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class CandidateProfile extends Model
{
    protected $fillable = ['user_id', 'resume_id', 'title', 'profile_image', 'summary', 'location', 'experience_years', 'portfolio_url', 'linkedin_url', 'github_url'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Use HasManyThrough to join resume via user table by user_id
    public function resumes(): HasManyThrough
    {
        return $this->hasManyThrough(Resumes::class, User::class, 'id', 'user_id', 'user_id', 'id');
    }

    public function defaultResume(): HasOneThrough {
        return $this->hasOneThrough(Resumes::class, User::class, 'id', 'user_id', 'user_id', 'id')->where('is_default', true);
    }
}
