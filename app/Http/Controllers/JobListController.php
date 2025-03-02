<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Company;
use App\Models\JobType;
use Illuminate\Http\Request;

class JobListController extends Controller
{
    public function index()
    {
        $companies = Company::get();
        $job_types = JobType::select('id', 'name')->get();
        $categories = Category::select('id', 'name')->get();

        $data = [
            'companies' => $companies,
            'categories' => $categories,
            'job_types' => $job_types,
        ];

        return view('front.jobs.index', compact('data'));
    }
}
