<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateProfile extends Model
{
    protected $fillable = ['user_id' , 'title', 'profile_image', 'summary', 'location', 'experience_years', 'portfolio_url', 'linkedin_url', 'github_url'];
}
