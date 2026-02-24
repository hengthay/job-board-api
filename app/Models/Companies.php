<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Companies extends Model
{
    protected $fillable = ['user_id', 'name', 'slug', 'logo_path', 'website_url', 'industry', 'company_size', 'location', 'description', 'verified_at'];

    public function companySocial() : HasMany {
        return $this->hasMany(CompanySocial::class, "company_id");
    }

    public function jobs() : HasMany {
        return $this->hasMany(Job::class, 'company_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
