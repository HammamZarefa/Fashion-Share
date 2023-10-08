<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Branch;
use App\Models\InvoicesProdect;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class InvoicesController extends Controller
{
    public function __invoke($id=null)
    {   
        $page_title = 'Invoices';
        $branchProduct = Auth::guard('admin')->user()->branch_id;
        $branchs = Branch::where(function($query) use($branchProduct){
           if(isset($branchProduct)){
            $query->where('id',$branchProduct); }
        })->select('id','name')->get();

        $invoices = InvoicesProdect::whereHas('products',function($query)use($branchProduct,$id){
            if(isset($branchProduct)){
            $query->where('branch_id',$branchProduct);
            }
            elseif(isset($id)){
                $query->where('branch_id',$id);
            }
        })->latest()->paginate(getPaginate());

        
    
        return view('admin.Invoices.index',compact('page_title','branchs','invoices'));
    }
}
