<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Company;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

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

    public function createJob(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => "required|string",
            "vacancy" => "required|numeric",
            "salary" => "nullable|numeric",
            "Location" => "nullable",
            "description" => "required",
            "benefits" => "nullable",
            "responsibility" => "nullable",
            "qualifications" => "nullable",
            "keywords" => "nullable",
            "experience" => "nullable|numeric",
            "company" => "required",
            "category" => "required",
            "job_type" => "required",
        ]);

        if ($validator->passes()) {
        } else {
            return Redirect::back()->withInput($request->all())->with(['errors' => $validator->errors()]);
        }
    }
}
