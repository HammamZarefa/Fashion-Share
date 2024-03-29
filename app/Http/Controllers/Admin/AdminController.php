<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Deposit;
use App\Models\Order;
use App\Models\Product;
use App\Models\Section;
use App\Models\User;
use App\Models\UserLogin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function search()
    {
        $extension='.blade.php';
        $path = 'resources/views';
        $names=['dashboard'];
        $files = array_diff(scandir($path), array('..', '.'));
        foreach($files as $f){
            $abs_path = $path.'/'.$f;
            if(is_dir($abs_path)){ //directory, recurse

            } else {  //file, test if the name ends with $extension
                $ext_length = strlen($extension);
                if(substr($f, -$ext_length) === $extension){
                    $names[] = $f;

                }
            }
        }
    }


    public function dashboard()
    {
        if (Auth::guard('admin')->user()->is_from_admin){
            $user = Auth::guard('admin')->user();
            $user->branch_id = null;
            $user->save();
            Auth::guard('admin')->loginUsingId($user->super_admin_id);
        }
        $page_title = 'Dashboard';

        // User Info
        $widget['total_users'] = User::count();
        $widget['total_Branch'] = Branch::count();
        $widget['total_Product'] = Product::count();
        $widget['total_Section'] = Section::count();
        $widget['total_Category'] = Category::count();



        $latestUser = User::latest()->limit(6)->get();
        $empty_message = 'User Not Found';
//        $is_branch_admin = false;
        return view('admin.dashboard', compact('page_title', 'widget','empty_message'));
    }


    public function profile()
    {
        $page_title = 'Profile';
        $admin = Auth::guard('admin')->user();
        return view('admin.profile', compact('page_title', 'admin'));
    }

    public function profileUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        $user = Auth::guard('admin')->user();

        if ($request->hasFile('image')) {
            try {
                $old = $user->image ?: null;
                $user->image = uploadImage($request->image, imagePath()['profile']['admin']['path'], imagePath()['profile']['admin']['size'], $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        $notify[] = ['success', 'Your profile has been updated.'];
        return redirect()->route('admin.profile')->withNotify($notify);
    }


    public function password()
    {
        $page_title = 'Password Setting';
        $admin = Auth::guard('admin')->user();
        return view('admin.password', compact('page_title', 'admin'));
    }

    public function passwordUpdate(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:5|confirmed',
        ]);

        $user = Auth::guard('admin')->user();
        if (!Hash::check($request->old_password, $user->password)) {
            $notify[] = ['error', 'Password Do not match !!'];
            return back()->withErrors(['Invalid old password.']);
        }
        $user->password = bcrypt($request->password);
        $user->save();
        $notify[] = ['success', 'Password Changed Successfully.'];
        return redirect()->route('admin.password')->withNotify($notify);
    }

    public function notifications(){
        $adminNotifications = AdminNotification::with('user')->orderBy('id','desc')->get();
        $page_title = 'Notifications';
        return view('admin.notifications',compact('page_title','adminNotifications'));
    }


    public function notificationRead($id){
        $notification = AdminNotification::findOrFail($id);
        $notification->read_status = 1;
        $notification->save();
        return redirect($notification->click_url);
    }


}
