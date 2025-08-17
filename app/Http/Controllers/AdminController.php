<?php

namespace App\Http\Controllers;

use App\Mail\VerificationCodeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function admin_logout(Request $request) 
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }



    public function admin_login(Request $request)
    {

       if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password]))
       {
           
            return redirect()->intended('/dashboard');
        }
        return redirect()->back()->withErrors(['email'=>'Invaild Credential Provided']);

    }

    public function showVerification()
    {
        return view('auth.verify');
    }

    public function verificationVerify(Request $request)
    {
        $request->validate(['code' => 'required|numeric']);

        if($request->code == session('verification_code'))
        {
            Auth::loginUsingId(session('user_id'));

            session()->forget('verification_code','user_id');

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['code' => 'Invalid Verification Code']);

    }


    public function admin_profile()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_profile', compact('profileData'));
    }

    public function profile_store(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        
        $oldPhotoPath = $data->photo;

        if ($request->file('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' .$file->getClientOriginalExtension();
            // Storage::put('upload/' . $filename, file_get_contents($file));
            $file->move(public_path('upload/'), $filename);
            $data->photo = $filename;

            if($oldPhotoPath && $oldPhotoPath !== $filename){
                $this->deleteOldImage($oldPhotoPath);
            }
        }

        $data->save();
        
            $notification = array(
            'message' => 'Profile Updated Successfully',
            'alert_type' => 'success',
        );
        return redirect()->back()->with($notification);

    }

    private function deleteOldImage(string $oldPhotoPath): void
    {
        $fullPath = public_path('upload/'.$oldPhotoPath);
        if(file_exists($fullPath)){
            unlink($fullPath);
        }
    }

    public function password_update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        if(!Hash::check($request->old_password,$user->password)){
            $notification = array(
                'message' =>  'Old Password does not match!',
                'alert_type' => 'error'
            );
            return back()->with($notification);
        }

        User::whereID($user->id)->update([
            'password' => Hash::make($request->new_password)

        ]);
        Auth::logout();

        $notification = array(
                'message' =>  'Password Updated Successfully!',
                'alert_type' => 'success '
            );
            return redirect()->route('login')->with($notification);

    }
}
