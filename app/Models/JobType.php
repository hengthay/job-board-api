<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobType extends Model
{
    protected $fillable = ['name'];

    public function job() : BelongsTo {
        return $this->belongsTo(Job::class, 'job_type_id');
    }
}
