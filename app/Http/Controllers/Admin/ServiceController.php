<?php

namespace App\Http\Controllers\Admin;

use App\Events\NotificationEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Models\Admin;
use App\Models\ApiProvider;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Color;
use App\Models\Condition;
use App\Models\GeneralSetting;
use App\Models\Image;
use App\Models\Material;
use App\Models\Product;
use App\Models\Section;
use App\Models\Service;
use App\Models\Size;
use App\Trait\NotificationTrait;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\Null_;

class ServiceController extends Controller
{
    use NotificationTrait;

    public function index()
    {
        $branch = Auth::guard('admin')->user()->branch_id;
        $page_title = 'Services';
        $empty_message = 'No Result Found';
        $categories = Category::orderBy('name')->get();
        if(is_null($branch)){
           
            $services = Product::
            with(['color', 'size', 'material', 'condition', 'section', 'branch', 'user', 'categories', 'images'])
           ->latest()->paginate(getPaginate());
        }
        else{ 
            $services = Product::
            with(['color', 'size', 'material', 'condition', 'section', 'branch', 'user', 'categories', 'images'])
           ->where('branch_id',$branch)->latest()->paginate(getPaginate());
           }
        return view('admin.products.list', compact('page_title', 'services', 'empty_message', 'categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'string',
            'price' => 'required',
            'category_id' => 'required|exists:categories,id',
            'color_id' => 'required|exists:colors,id',
            'material_id' => 'required|exists:materials,id',
            'section_id' => 'required|exists:sections,id',
            'size_id' => 'required|exists:sizes,id',
            'condition_id' => 'required|exists:conditions,id',
            'branch_id' => 'required|exists:branches,id',
            'is_for_sale' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($validator->fails()) {
            $notify[] = ['error', 'validation'];
            return back()->withNotify($notify);   
        }
        $product = Product::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'category_id' => $request->input('category_id'),
            'color_id' => $request->input('color_id'),
            'material_id' => $request->input('material_id'),
            'section_id' => $request->input('section_id'),
            'size_id' => $request->input('size_id'),
            'condition_id' => $request->input('condition_id'),
            'user_id' => auth()->id(),
            'branch_id' => $request->input('branch_id'),
            'status' => 'pending',
            'is_for_sale' => $request->input('is_for_sale')
        ]);
        $product->categories()->attach($request->category_id);
        if (isset($request['images'])) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('public/images', $filename);

                // Create the image record in the database
                $product->images()->create([
                    'path' => $filename,
                    // Add other image fields as needed
                ]);
            }
        }
   

        $notify[] = ['success', 'Service added!'];
        return back()->withNotify($notify);
    }

    public function update( $product,Request $request)
    {
        
        $product = Product::findOrFail($product);
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'description' => 'string',
            'price' => 'numeric',
            'category_id' => 'exists:categories,id',
            'color_id' => 'exists:colors,id',
            'material_id' => 'exists:materials,id',
            'section_id' => 'exists:sections,id',
            'size_id' => 'exists:sizes,id',
            'condition_id' => 'exists:conditions,id',
            'branch_id' => 'exists:branches,id',
            'is_for_sale' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            // return back()->withNotify(['error' => $validator->messages()]);
        }

        $product->update($request->only([
            'name',
            'description',
            'price',
            'category_id',
            'color_id',
            'material_id',
            'section_id',
            'size_id',
            'condition_id',
            'branch_id',
            'is_for_sale'
        ]));

        if ($request->category_id)
            $product->categories()->sync($request->category_id);
        if (isset($request['images'])) {
            foreach ($request['images'] as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('public/images', $filename);
                // Create or update the image record in the database
                $product->images()->create([
                    'path' => $filename,
                    'imagable_id'=>$product->id

                ]);
            }
        }
        if(isset($request['status'])){
            if($request['status'] = "available"){
                $this->send_event_notification($product->user , '', ' تم تفعيل منتجك ', 'Your product has been activated' );}
            if($request['status'] = "not_available"){
               $this->send_event_notification( $product->users,'', ' تم الغاء تفعيل منتجك ' , 'Your product has been deactivated'  );}
            if($request['status'] = "sale"){ 
                $this->send_event_notification( $product->user,'', ' تم تغيير حالة منتجك الى بيع ' , 'Your product status has been changed to Sold' );}
            if($request['status'] = "rent"){
                 $this->send_event_notification( $product->user, '',' تم تغيير حالة منتجك الى أجار ' , 'Your product status has been changed to Rent'  );}
            if($request['status'] = "rejected"){ 
                $this->send_event_notification( $product->user,'', ' تم رفض منتجك' , 'Your product has been rejected' );}

        }
        $notify[] = ['success', 'product updated!'];
        return back()->withNotify($notify);
    }

    private function serviceAction($service, $request)
    {
        $service->category_id = $request->category;
        $service->name = $request->name;
        $service->price_per_k = $request->price_per_k;
        $service->min = $request->min;
        $service->max = $request->max;
        $service->details = $request->details;
        if ($service->category->type == "5SIM")
            $service->api_service_params = $request->country . '/any/' . $request->product;
        $service->special_price = $request->special_price != 0 ? $request->special_price : NULL;
        $service->api_service_id = $request->api_service_id;
        if ($request->api_provider_id)
            $service->api_provider_id = $request->api_provider_id;

    }

    public function status($id)
    {
        $service = Service::findOrFail($id);
        $service->status = ($service->status ? 0 : 1);
        $service->save();

        $notify[] = ['success', 'Status updated!'];
        return back()->withNotify($notify);
    }

    //Api services
    public function apiServices($id)
    {
        $page_title = 'API Services';
        $empty_message = 'No Result Found';
        $categories = Category::active()->orderBy('name')->get();
        $general = ApiProvider::findOrFail($id);
        if ($id == 1 || $id == 3) {
            $url = $general->api_url;
            $arr = [
                'key' => $general->api_key,
                'action' => "services",
            ];
        } elseif ($id == 2) {
            $url = $general->api_url . '/products';
            $header = array(
                "Content-Type" => "application/json",
                "api_key" => $general->api_key
            );
            $arr = [

            ];
        }
        $response = json_decode(curlPostContent($url, $arr, @$header));
        if (@$response->error) {
            $notify[] = ['info', 'Please enter your api credentials from API Setting Option'];
            $notify[] = ['error', $response->error];
            return back()->withNotify($notify);
        }
        if ($id == 1 || $id == 3)
            $response = collect($response);
        elseif ($id == 2)
            $response = collect($response->products);
        $services = $this->paginate($response, getPaginate(), null, ['path' => route('admin.services.apiServices', $id)]);
        return view('admin.services.apiServices', compact('page_title', 'services', 'empty_message', 'categories', 'id'));
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }


    public function search(Request $request)
    {

        if ($request->search) {
            $search = $request->search;
            $categories = Category::active()->orderBy('name')->get();
            $services = Service::where('category_id', $search)->latest('id')->paginate(getPaginate());
            $search = Category::find($search);
            $page_title = "نتائج البحث عن {{$search['name']}}";
        } else {
            $page_title = 'All Services';
            $search = '';
            $services = Service::with('category')->latest()->paginate(getPaginate());
            $categories = Category::active()->orderBy('name')->get();
        }
        $empty_message = 'No Result Found';
        return view('admin.services.index', compact('page_title', 'services', 'empty_message', 'search', 'categories'));
    }

    public function edite($service){
        $page_title = 'Services';
        $empty_message = 'No Result Found';
        $categories = Category::find($service);
        $Colors = Color::all();
        $Sizes = Size::all();
        $Conditions = Condition::all();
        $Materials = Material::all();
        $Sections = Section::all();
        $branchs = Branch::all();
        $Categories= Category::all();

        $services = Product::findOrFail($service);

        return view('admin.products.edit', 
        compact('page_title', 'services', 'Categories','empty_message', 'categories' ,'Colors','Sizes','Conditions','Materials','Sections','branchs'));

    }

    public function create(){
        $page_title = 'Services';
        $empty_message = 'No Result Found';
        $Colors = Color::all();
        $Sizes = Size::all();
        $Categories= Category::all();
        $Conditions = Condition::all();
        $Materials = Material::all();
        $Sections = Section::all();
        $branchs = Branch::all();

        $services = Product::
        with(['color', 'size', 'material', 'condition', 'section', 'branch', 'user', 'categories', 'images'])
            ->latest()->paginate(getPaginate());
        return view('admin.products.create', 
        compact('page_title', 'empty_message' ,'Colors','Categories','Sizes','Conditions','Materials','Sections','branchs'));
    }

    public function deleteImage($id){
      $image =  Image::findOrFail($id);
      if(File::exists(public_path($image))){
        File::delete(public_path('upload/bio.png'));
        }
        $image->delete();
    }
}
