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
        $branch = Branch::all();
        return view ('admin.branch.index',compact('branch','page_title','empty_message'));
    }

    public function store(Request $request){
        \request()->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'location' => 'nullable|string',
            'working_hours'=>'nullable|string',
            'phone'=>'nullable|string',
            'whatsapp'=>'nullable|string',
        ]);
        // dd($request);
        $branch = Branch::create([
            'name' => \request()->name,
            'address' => \request()->address,
            'location' => \request()->location,
            'working_hours'=> \request()->working_hours,
            'phone'=> \request()->phone,
            'whatsapp'=> \request()->whatsapp,
        ]);
        
        $notify[] = ['success', 'Branch created!'];
        return back()->withNotify($notify);
    }

    public function update($id, Request $request){
        \request()->validate([
            'name' => 'nullable|string',
            'address' => 'nullable|string',
            'location' => 'nullable|string',
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
        
        $branch->save();

        $notify[] = ['success', 'Branch updated!'];
        return back()->withNotify($notify);
    }    

    public function delete($id){
        $item = Branch::findOrFail($id);
        $item->delete();
        $notify[] = ['success','branch deleted!'];
        return back()->withNotify($notify);
    }
}
