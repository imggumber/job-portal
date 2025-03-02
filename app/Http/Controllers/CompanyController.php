<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function addCompany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'companyName' => 'required|max:120|string',
            'companyAddress' => 'nullable|max:255',
            'companyWebsite' => 'nullable|url:https',
        ]);

        if ($validator->passes()) {
            Company::create([
                'name' => $request->companyName,
                'location' => $request->companyAddress,
                'website' => $request->companyWebsite,
            ]);

            session()->flash('message', 'Company added successfully');

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
