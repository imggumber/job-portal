<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyJob extends Model
{
    protected $table = "company_jobs";

    protected $fillable = [
        'job_list_id',
        'company_id',
    ];

}
