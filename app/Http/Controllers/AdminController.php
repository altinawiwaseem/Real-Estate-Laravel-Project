<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;



class AdminController extends Controller
{
    //Admin Dashboard
    public function adminDashboard(){
        return view('admin.index');
    }



    public function adminLogout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('admin/login');
    }


    public function adminLogin(){
        return view('admin.admin_login');
    }

    public function adminProfile(){
        //$id = Auth::user()->id;
        $profileData = Auth::user();
        return view('admin.admin_profile', compact('profileData'));
    }


    public function adminProfileStore(Request $request){
        $userData = Auth::user();

        $userData->username = $request->username;
        $userData->email = $request->email;
        $userData->name = $request->name;
        $userData->phone = $request->phone;
        $userData->address = $request->address;

        if($request->file('photo')){
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/'.$userData->photo));
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'),$filename);
            $userData['photo'] = $filename;

        }

        $userData->save();

        $notification = array(
            'message'=> 'Admin Profile Updated Successfully',
            'alert-type'=>'success'
        );

        return redirect()->back()->with($notification);



    }
}
