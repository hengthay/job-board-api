<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanySocial extends Model
{
    protected $fillable = ['company_id', 'platform', 'url'];

    public function companies() : BelongsTo {
        return $this->belongsTo(Companies::class, "company_id");
    }
}
