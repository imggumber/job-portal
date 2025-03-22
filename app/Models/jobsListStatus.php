<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobsListStatus extends Model
{
    protected $table = 'jobs_list_statuses';

    protected $fillable = [
        'job_id',
        'job_status_id',
        'created_at',
        'updated_at',
    ];
}

