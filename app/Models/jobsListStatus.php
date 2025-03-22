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

    public function jobList()
    {
        $this->belongsTo(JobList::class, 'job_id');
    }

    public function JobStatus()
    {
        $this->belongsTo(JobsListStatus::class, 'job_status_id');
    }
}
