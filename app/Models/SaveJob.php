<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaveJob extends Model
{
    protected $fillable = ['user_id', 'job_id', 'is_active'];

    public function job() {
        return $this->belongsTo(Job::class, 'job_id');
    }
}
