<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppliedJobController extends Controller
{
    public function appliedJob()
    {
        return view('front.jobs.jobs-applied');
    }
}
