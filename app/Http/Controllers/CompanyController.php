<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function allCompanies()
    {
        $companies = Company::select('id', 'name', 'website', 'location')->get();
        return view('front.company.company', compact('companies'));
    }

    public function getCompany($id = null)
    {
        $company = Company::select('name', 'website', 'location')->where('id', $id)->first();
        if (!$company) {
            return response()->json([
                'status' => false,
                'data'   => []
            ]);
        } else {
            return response()->json([
                'status' => true,
                'data'   => $company,
            ]);
        }
    }

    public function addCompany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'companyName' => 'required|max:120|string',
            'companyAddress' => 'nullable|max:255',
            'companyWebsite' => 'nullable|url:https',
        ]);

        $companySlug = str_replace(" ", "-", $request->companyName);

        $companyExists = Company::where('slug', $companySlug)->first();

        if ($companyExists) {
            return response()->json([
                'status' => false,
                'errors' => ["slug" => "Company already exists"],
            ]);
        }

        if ($validator->passes()) {
            Company::create([
                'name' => $request->companyName,
                'slug' => $companySlug,
                'location' => $request->companyAddress,
                'website' => $request->companyWebsite,
            ]);

            session()->flash('success', 'Company added successfully');

            return response()->json([
                'status' => true,
                'errors' => [],
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }
}
