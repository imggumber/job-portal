<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Company;
use App\Models\CompanyJob;
use App\Models\JobList;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
            "location" => "nullable",
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
            $userId = Auth::user()->id;
            DB::beginTransaction();
            try {
                $jobList = JobList::create([
                    'title' => $request->title,
                    'vacancy' => $request->vacancy,
                    'salary' => $request->salary,
                    'location' => $request->location,
                    'description' => $request->description,
                    'benefits' => $request->benefits,
                    'responsiblity' => $request->responsibility,
                    'qualifications' => $request->qualifications,
                    'keywords' => $request->keywords,
                    'experience' => $request->experience,
                    'category_id' => $request->category,
                    'job_type_id' => $request->job_type,
                    'user_id' => $userId,
                ]);

                CompanyJob::create([
                    'job_list_id' => $jobList->id,
                    'company_id'  => $request->company,
                ]);

                DB::commit();
                return Redirect::back()->with('success', 'Job saved successfully');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::alert($e->getMessage());
                return Redirect::back()->withInput($request->all())->with('error', 'Internal Server Error');
            }
        } else {
            return Redirect::back()->withInput($request->all())->with(['errors' => $validator->errors()]);
        }
    }
}
