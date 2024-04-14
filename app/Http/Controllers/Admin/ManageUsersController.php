<?php

namespace App\Http\Controllers\Admin;

use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


class ManageUsersController extends Controller
{
    public function allUsers()
    {
        $page_title = 'Manage Users';
        $empty_message = 'No user found';
        $users = User::latest()->paginate(getPaginate());
        return view('admin.users.list', compact('page_title', 'empty_message', 'users'));
    }

    public function store()
    {
        \request()->validate([
            'email' => 'nullable|string|max:70',
            'password' => 'required|string|max:70',
            'phone' => 'required|string|max:70',
            'image' => '',
        ]);
        $request = \request();
        $user = new User();
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->phone = $request->phone;
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
            $user->image = $filename;
        }
        $user->save();

        $notify[] = ['success', 'User added!'];
        return back()->withNotify($notify);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        if ($user->images) {
            $path = imagePath()['profile']['admin']['path'];
            removeFile($path . '/' . $user);
        }
        $user->delete();
        $notify[] = ['success', 'User Deletedd!'];
        return back()->withNotify($notify);
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'email' => 'nullable|email|max:160|unique:users,email,' . $user->id,
            'phone' => 'required|max:160|unique:users,phone,' . $user->id,
        ]);

        if ($request->email && $request->email != $user->email && User::whereEmail($request->email)->whereId('!=', $user->id)->count() > 0) {
            $notify[] = ['error', 'Email already exists.'];
            return back()->withNotify($notify);
        }
        if ($request->phone != $user->phone && User::where('phone', $request->phone)->whereId('!=', $user->id)->count() > 0) {
            $notify[] = ['error', 'Phone number already exists.'];
            return back()->withNotify($notify);
        }
        $user->phone = $request->phone;
        $user->email = $request->email;
        if ($request->password)
            $user->password = bcrypt($request->password);
        $user->save();

        $notify[] = ['success', 'User detail has been updated'];
        return redirect()->back()->withNotify($notify);
    }
}
