<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = ['job_id', 'user_id', 'resume_id', 'cover_letter', 'status', 'applied_at', 'reviewd_at', 'employer_note'];
}
