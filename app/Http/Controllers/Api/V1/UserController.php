<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\UserResource;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function products()
    {
        $user = auth()->user();
        $supplier = Supplier::where('user_id',$user->id)->first();
       if($supplier)
           $products = $supplier->products;
       else
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
            'email' => ['nullable', 'email'],
            'image' => ['mimes:jpeg,jpg,png,gif|max:10000'],
            'phone' => ['string']
        ]);

        $user = auth()->user();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();

            // Store the file in the desired disk
            Storage::disk('public')->putFileAs('images', $file, $fileName);

            // Retrieve the URL to access the uploaded file
            $image = Storage::disk('public')->url('images/' . $fileName);
            Log::debug($image);
            $user->image = $image;
        }
        $user->email = isset($request->email) ? $request->email: $user->email;
        $user->phone =  isset($request->phone) ? $request->phone: $user->phone;
        $user->save();
        return UserResource::make($user);
    }
}
