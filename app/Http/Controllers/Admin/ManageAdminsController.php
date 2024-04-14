<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Branch;
use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\SupportTicket;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class ManageAdminsController extends Controller
{
    public function allUsers()
    {
        $page_title = 'Manage Users';
        $empty_message = 'No user found';
        $branches = Branch::all();
        $users = Admin::where('branch_id', '<>', null)->where('is_from_admin', 0)->latest()->paginate(getPaginate());
        return view('admin.admins.list', compact('page_title', 'empty_message', 'users', 'branches'));
    }

    public function store()
    {
        \request()->validate([
            'name' => 'required|string|max:70',
            'username' => 'required|string|max:70',
            'email' => 'required|string|max:70',
            'password' => 'required|string|max:70',
            'mobile' => 'required|string|max:70',
            'branch_id' => 'required|exists:branches,id',
            'image' => '',
        ]);
        $request = \request();
        $admin = new Admin();
        $admin->name = $request->name;
        $admin->username = str_replace(' ', '_', $request->username);
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->mobile = $request->mobile;
        $admin->branch_id = $request->branch_id;
        $image = $request->file('image');
        $path = imagePath()['profile']['admin']['path'];
        $size = imagePath()['profile']['admin']['size'];
        $filename = $request->image;
        if ($request->hasFile('image')) {
            try {
                $filename = uploadImage($image, $path, $size, $filename);
            } catch (\Exception $exp) {
                $notify[] = ['errors', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
            $admin->image=$filename;
        }

        $admin->save();

        $notify[] = ['success', 'User added!'];
        return back()->withNotify($notify);
    }

    public function updateAdmin($id, Request $request)
    {
        \request()->validate([
            'name' => 'required|string|max:70',
            'username' => 'required|string|max:70',
            'email' => 'required|string|max:70',
            'mobile' => 'required|string|max:70',
            'branch_id' => 'required|exists:branches,id',
            'image' => '',
        ]);
        $admin = Admin::findOrFail($id);
        $admin->name = $request->name;
        $admin->username = str_replace(' ', '_', $request->username);
        $admin->email = $request->email;
        $admin->mobile = $request->mobile;
        $admin->branch_id = $request->branch_id;
        $image = $request->file('image');
        $path = 'assets/admin/images/';
        $size = imagePath()['profile']['admin']['size'];
        $oldImage = $admin->image;
        if ($request->hasFile('image')) {
            try {
                $filename = uploadImage($image, $path, $size, $oldImage);
            } catch (\Exception $exp) {
                $notify[] = ['errors', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
            $admin->image=$filename;
        }
        $admin->save();

        $notify[] = ['success', 'User updated!'];
        return back()->withNotify($notify);
    }
    public function delete($id){

        $admin = Admin::findOrFail($id);
        if($admin->images){
            $path = imagePath()['profile']['admin']['path'];
            removeFile($path . '/' . $admin);
        }
        $admin->delete();
        $notify[] = ['success', 'User Deletedd!'];
        return back()->withNotify($notify);
    }

}
