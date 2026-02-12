<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySocial extends Model
{
    protected $fillable = ['company_id', 'platform', 'url'];
}
