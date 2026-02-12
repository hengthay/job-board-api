<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateProfile extends Model
{
    protected $fillable = ['user_id', 'title', 'summary', 'location', 'experience_year', 'portfolio_url', 'linkedin_url', 'github_url'];
}
