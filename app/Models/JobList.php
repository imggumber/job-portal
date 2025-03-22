<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobList extends Model
{
    protected $table = 'job_lists';

    protected $fillable = [
        "title",
        "vacancy",
        "salary",
        "location",
        "description",
        "benefits",
        "responsiblity",
        "qualifications",
        "keywords",
        "experience",
        "category_id",
        "job_type_id",
        "user_id",
    ];

    public function jobStatuses()
    {
        return $this->hasOne(JobsListStatus::class, 'job_id');
    }
}
