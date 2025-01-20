<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


use function Laravel\Prompts\password;

class AdminController extends Controller
{
    //Admin Dashboard
    public function adminDashboard()
    {
        return view('admin.index');
    }



    public function adminLogout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('admin/login');
    }


    public function adminLogin()
    {
        return view('admin.admin_login');
    }

    public function adminProfile()
    {
        //$id = Auth::user()->id;
        $profileData = Auth::user();
        return view('admin.admin_profile', compact('profileData'));
    }


    public function adminProfileStore(Request $request)
    {
        $userData = Auth::user();

        $request->validate([
            'username' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $userData->id,
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:100',
            'photo' => 'nullable|mimes:jpeg,jpg,png,gif|max:10000'
        ]);

        $userData->username = Str::of($request->username)->trim()->stripTags();
        $userData->email = Str::of($request->email)->trim();
        $userData->name = Str::of($request->name)->trim()->stripTags();
        $userData->phone = Str::of($request->phone)->trim();
        $userData->address = Str::of($request->address)->trim()->stripTags();

        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/' . $userData->photo));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);
            $userData->photo = $filename;
        };

        $userData->save();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function adminChangePassword()
    {
        $profileData = Auth::user();

        return view('admin.admin_change_password', compact('profileData'));
    }


    public function adminUpdatePassword(Request $request)
    {

        //Validation

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        // Match The Old Password

        if (!Hash::check($request->old_password, auth::user()->password)) {

            $notification = array(
                'message' => 'Old Password Does not Match!',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        };


        //Update New Password
        auth::user()->update([
            'password' => Hash::make($request->new_password)
        ]);

        $notification = array(
            'message' => 'Password Changed Successfully',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }
}
