<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function register()
    {
        return view('front.accounts.register');
    }

    public function registerUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:5|same:confirm_password",
            "confirm_password" => "required|min:5",
        ]);

        if ($validator->passes()) {

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            session()->flash('success', 'You have registered successfully');

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

    public function login()
    {
        return view('front.accounts.login');
    }

    public function loginUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required"
        ]);

        if ($validator->passes()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password ])) {
                return redirect()->route("account.profile");
            } else {
                return redirect()->route("account.login")->with("error", "Invalid credentials")->withInput($request->only('email'));
            }
        } else {
            return redirect()->route("account.login")->withErrors($validator)->withInput($request->only('email'));
        }
    }

    public function profile()
    {
        return view('front.accounts.profile');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route("account.login")->with('success', 'Logout successfully');
    }
}
