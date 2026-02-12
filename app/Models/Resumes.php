<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resumes extends Model
{
    protected $fillable = ['user_id', 'file_path', 'file_name', 'mime_type', 'is_default'];
}
