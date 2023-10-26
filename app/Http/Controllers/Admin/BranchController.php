<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index(){
        $page_title = 'Branch';
        $empty_message = 'No Result Found';
        $branch = Branch::with('Admin')->get();
        return view ('admin.branch.index',compact('branch','page_title','empty_message'));
    }

    public function edit($id){
        $page_title = 'Branch';
        $empty_message = 'No Result Found';
        $item = Branch::with('Admin')->find($id);
        return view ('admin.branch.edit',compact('item','page_title','empty_message'));
    }

    public function store(Request $request){
        \request()->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            
            'location' => 'nullable|string',
            
            'latitude'=> 'nullable|string',
            'longitude'=> 'nullable|string',

            'working_hours'=>'nullable|string',
            'phone'=>'nullable|string',
            'whatsapp'=>'nullable|string',
        ]);

        $branch = Branch::create([
            'name' => \request()->name,
            'address' => \request()->address,
            'location' => \request()->location,
            'working_hours'=> \request()->working_hours,
            'phone'=> \request()->phone,
            'whatsapp'=> \request()->whatsapp,
            'latitude' => \request()->latitude,
            'longitude' => \request()->longitude,
            'location'=> \request()->latitude .','. \request()->longitude,
        ]);
        
        $notify[] = ['success', 'Branch created!'];
        return back()->withNotify($notify);
    }

    public function update($id, Request $request){
        \request()->validate([
            'name' => 'nullable|string',
            'address' => 'nullable|string',
            
            'location' => 'nullable|string',
            
            'latitude'=> 'nullable|string',
            'longitude'=> 'nullable|string',

            'working_hours'=>'nullable|string',
            'phone'=>'nullable|string',
            'whatsapp'=>'nullable|string',
        ]);
        $branch = Branch::findOrFail($id);
        $branch->name = \request()->name;
        $branch->address = \request()->address;
        $branch->location  = \request()->location;
        $branch->working_hours = \request()->working_hours;
        $branch->phone =  \request()->phone;
        $branch->whatsapp = \request()->whatsapp;
        $branch->latitude = \request()->latitude;
        $branch->longitude = \request()->longitude;
        $branch->location =  \request()->latitude .','  .\request()->longitude;

        $branch->save();
        $notify[] = ['success', 'Branch updated!'];
        return redirect()->route('admin.branch')->withNotify($notify);

    }    

    public function delete($id){
        $item = Branch::findOrFail($id);
        $item->delete();
        $notify[] = ['success','branch deleted!'];
        return back()->withNotify($notify);
    }
}
