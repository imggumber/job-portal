<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
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
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
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
        $user_id = Auth::user()->id;

        $user = User::where('id', $user_id)->first();

        return view('front.accounts.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user_id = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:120",
            "email" => "required|email|unique:users,email," . $user_id . ",id",
            "designation" => "sometimes|nullable|string|max:120",
            "mobile" => "sometimes|nullable|numeric"
        ]);

        if ($validator->passes()) {
            $user = User::find($user_id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->designation = $request->designation;
            $user->mobile = $request->mobile;

            $user->save();

            session()->flash('success', 'Profile updated successfully');

            return response()->json([
                "status" => true,
                "errors" => [],
            ]);
        } else {
            return response()->json([
                "status" => false,
                "errors" => $validator->errors(),
            ]);
        }
    }

    public function updateProfilePic(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|max:500'
        ]);

        if ($validator->passes()) {
            $image = $request->image;
            $extension = $image->getClientOriginalExtension();
            $imageName = Carbon::now()->timestamp . "." . $extension;
            $image->move(public_path("profiles"), $imageName);

            // Remove old file
            if (Auth::user()->image != "" || Auth::user()->image != null) {
                File::delete(public_path("profiles/" . Auth::user()->image));
            }

            User::where('id', Auth::user()->id)->update(['image' => $imageName]);

            session()->flash("success", "Profile pic updated successfully");

            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route("account.login");
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ], [
            'old_password.required' => 'Enter your old password',
            'password.required' => 'Enter your new password',
            'password.required' => 'Enter your new password',
            'password_confirmation.required' => 'Re-enter your new password',
            'password_confirmation.min' => 'The confirm password field must be at least 6 characters.',
        ]);

        if ($validator->passes()) {
            // Check if requested old password is same as saved password
            $oldPassword = User::select('password')->where('id', Auth::user()->id)->first();
            $checkOldPassword = Hash::check($request->old_password, $oldPassword->password);
            if ($checkOldPassword) {
                DB::beginTransaction();
                try {
                    User::where('id', Auth::user()->id)->update(['password' => Hash::make($request->password)]);
                    DB::commit();
                    return Redirect::back()->with('success', 'Password updated successfully');
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::alert($e->getMessage());
                    return Redirect::back()->with('error', 'Internal Server Error');
                }
            } else {
                return Redirect::back()->with('error', 'Incorrect old password');
            }
        } else {
            return Redirect::back()->with(['errors' => $validator->errors()]);
        }
    }
}
