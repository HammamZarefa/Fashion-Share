<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Branch;
use App\Models\InvoicesProdect;
use App\Models\Product;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class RentsController extends Controller
{
    public function __invoke($id=null)
    {
        $page_title = 'Rents';
        $branch_id = Auth::guard('admin')->user()->branch_id;
        $branch = Branch::where(function($query) use($branch_id){
            if(isset($branch_id)){
                $query->where('id',$branch_id); }
        })->select('id','name')->first();

        $invoices = InvoicesProdect::where('is_rent',true)->whereHas('products',function($query)use($branch_id,$id){
            if(isset($branch_id)){
                $query->where('branch_id',$branch_id);
            }
            elseif(isset($id)){
                $query->where('branch_id',$id);
            }
        })->latest()->paginate(getPaginate());



        return view('admin.rent.index',compact('page_title','id','branch','invoices'));
    }

    public function create()
    {
        $page_title = 'Rent Create';
        $branch_id = Auth::guard('admin')->user()->branch_id;
        $products = Product::where('branch_id',$branch_id)
            ->where('status', 'available')
            ->whereHas('section',function($query){
                    $query->where('is_rent',true);
            })
            ->get();
        $lastInvoice = InvoicesProdect::get()->last();
        return view('admin.rent.create',compact('page_title','products','lastInvoice'));
    }

    public function store(Request $request)
    {
        $branchAdmin = Auth::guard('admin')->user();
        $invoice = new InvoicesProdect();
        $invoice->status = 'created';
        $invoice->is_rent = true;
        $invoice->discount = null;
        $invoice->date_of_process = Carbon::now();
        $invoice->price = (float)$request->total_price;

        $invoice->user_id = null;
        $invoice->date_of_return = null;
        $invoice->username = $request->client_name;
        $invoice->mobile = $request->mobile;
        foreach ($request->products as $product){
            $details[] = [
                'product_id' => $product,
                'return_date' =>$request['return_date_'.$product]
            ];
        }
        $invoice->details = json_encode($details,true);
        $invoice->save();
        foreach ($request->products as $product){
            $invoice->products()->attach($product);
        }

        return redirect()->route('admin.rents')->with('success','Invoice Added Successfully');

        dd($request);
    }
}
