<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobCategory extends Model
{
    protected $fillable = ['name'];

    public function job() : HasMany {
        return $this->hasMany(Job::class, 'job_category_id');
    }
}
