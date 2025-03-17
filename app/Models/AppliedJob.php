<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppliedJob extends Model
{
    protected $table = 'applied_jobs';

    protected $fillable = [
        'applied_on',
        'job_status_id',
        'job_id',
        'user_id',
    ];
}
