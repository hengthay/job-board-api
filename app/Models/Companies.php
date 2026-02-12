<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    protected $fillable = ['user_id', 'name', 'slug', 'logo_path', 'website_url', 'industry', 'company_size', 'location', 'description', 'verified_at'];
}
