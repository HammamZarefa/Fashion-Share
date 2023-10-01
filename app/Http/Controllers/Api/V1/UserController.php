<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function products()
    {
        $user = auth()->user();
        $products = $user->products;
        return ProductResource::collection($products);
    }

    public function getInfo()
    {
        $user = auth()->user();
        return UserResource::make($user);
    }

    public function updateInfo(UpdateUserRequest $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'image' => ['mimes:jpeg,jpg,png,gif|max:10000'],
            'phone' => ['string']
        ]);

        $user = auth()->user();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '-' . $image->getClientOriginalName();
            $image->storeAs('public/images', $filename);
            $user->image = $filename;
        }
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();
        return UserResource::make($user);
    }
}
