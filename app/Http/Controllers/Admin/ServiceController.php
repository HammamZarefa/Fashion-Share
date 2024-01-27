<?php

namespace App\Http\Controllers\Admin;

use App\Actions\GenerateSkuAction;
use App\Events\NotificationEvent;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Category;
use App\Models\categoryProduct;
use App\Models\Color;
use App\Models\Condition;
use App\Models\GeneralSetting;
use App\Models\Image;
use App\Models\InvoicesProdect;
use App\Models\Material;
use App\Models\Product;
use App\Models\Season;
use App\Models\Section;
use App\Models\Size;
use App\Models\Style;
use App\Models\Supplier;
use App\Models\User;
use App\trait\NotificationTrait;
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

use function PHPUnit\Framework\isNull;

class ServiceController extends Controller
{
    use NotificationTrait;

    public function index()
    {
        $sections = Section::all();
        $branch = Auth::guard('admin')->user()->branch;
        $page_title = 'Services';
        $empty_message = 'No Result Found';
        $categories = Category::orderBy('name')->get();
        if (is_null($branch)) {
            $branches = Branch::whereHas('products')->groupBy('id')->get();
            $services = Product::
            with(['color', 'size', 'material', 'condition', 'section', 'branch', 'user', 'categories', 'images'])
                ->latest()->paginate(getPaginate());
        } else {
            $branches = $branch;
            $services = Product::
            with(['color', 'size', 'material', 'condition', 'section', 'branch', 'user', 'categories', 'images'])
                ->where('branch_id', $branch->id)->latest()->paginate(getPaginate());
        }
        return view('admin.products.list',
            compact('page_title', 'sections', 'services', 'branches', 'empty_message', 'categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required',
            'category_id' => 'required|exists:categories,id',
            'color_id' => 'required|exists:colors,id',
            'material_id' => 'required|exists:materials,id',
            'section_id' => 'required|exists:sections,id',
            'size_id' => 'required|exists:sizes,id',
            'condition_id' => 'required|exists:conditions,id',
            'branch_id' => 'required|exists:branches,id',
            'is_for_sale' => 'required',
            'images' => 'array',
            'images.*' => 'mimes:jpg,jpeg,png,bmp|max:2000',
            'location' => 'nullable|string',
            'status' => 'required',
            'user_id' => 'nullabel|exists:users,id',
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
            'location' => $request->input('location'),
            'user_id' => auth()->id(),
            'branch_id' => $request->input('branch_id'),
            'status' => $request->input('status'),
            'is_for_sale' => $request->input('is_for_sale'),
            'user_id' => $request->input('user_id'),
        ]);
        $product->update([
            'sku' => GenerateSkuAction::execute($product->branch_id, $product->section_id, $request->category_id, $product->id)
        ]);
        $product->categories()->attach($request->category_id);
        if (isset($request['images'])) {
            foreach ($request->file('images') as $image) {
                $path = imagePath()['service']['path'];
                $size = imagePath()['service']['size'];
                $filename = $image;

                $filename = uploadImage($image, $path, $size, $filename);
                // $product->image=$filename;
                // Create the image record in the database
                $product->images()->create([
                    'path' => $filename,
                    // Add other image fields as needed
                ]);
            }
        }

        if (isset($request['status'])) {
            if (($request['status'] == 'sale') || $request['status'] == 'rent') {
                $this->insertInInvoices($product);
            }
        }
        $notify[] = ['success', 'Service added!'];

        return redirect()->route('admin.services.index')->withNotify($notify);
    }

    public function update($product, Request $request)
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
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'nullable',
            'location' => 'nullable|string',
            'user_id' => 'nullabel|exists:users,id',

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
            'status',
            'is_for_sale',
            'location',
            'user_id',
        ]));

        if ($request->category_id)
            $product->categories()->sync($request->category_id);
        if (isset($request['images'])) {
            foreach ($request->file('images') as $image) {
                $path = imagePath()['service']['path'];
                $size = imagePath()['service']['size'];
                $filename = $image;

                $filename = uploadImage($image, $path, $size, $filename);
                // $product->image=$filename;
                // Create the image record in the database
                $product->images()->create([
                    'path' => $filename,
                    // Add other image fields as needed
                ]);
            }
        }
        if (isset($request['status'])) {
            if ($product->user) {
                if ($request['status'] = "available") {
                    $this->send_event_notification(User::find($product->user->id), '', ' تم تفعيل منتجك ', 'Your product has been activated');
                }
                if ($request['status'] = "not_available") {
                    $this->send_event_notification(User::find($product->user->id), '', ' تم الغاء تفعيل منتجك ', 'Your product has been deactivated');
                }
                if ($request['status'] = "sale") {
                    $this->send_event_notification(User::find($product->user->id), '', ' تم تغيير حالة منتجك الى بيع ', 'Your product status has been changed to Sold');
                }
                if ($request['status'] = "rent") {
                    $this->send_event_notification(User::find($product->user->id), '', ' تم تغيير حالة منتجك الى أجار ', 'Your product status has been changed to Rent');
                }
                if ($request['status'] = "rejected") {
                    $this->send_event_notification($product->user, '', ' تم رفض منتجك', 'Your product has been rejected');
                }
            }
        }

        if (isset($request['status'])) {
            if (($request['status'] == 'sale') || $request['status'] == 'rent') {
                $this->insertInInvoices($product);
            }
        }
        $notify[] = ['success', 'product updated!'];
        return redirect()->route('admin.services.index')->withNotify($notify);
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

    public function edit($service)
    {
        $page_title = 'Services';
        $empty_message = 'No Result Found';
        $Colors = Color::all();
        $Sizes = Size::with('category')->get();
        $Conditions = Condition::all();
        $Materials = Material::all();
        $Sections = Section::with('category')->get();
        $branchs = Branch::all();
        $Categories = Category::with(['section', 'sizes'])->get();
        $Users = User::all();

        $services = Product::with('images')->findOrFail($service);
        return view('admin.products.edit',
            compact('page_title', 'services', 'Categories', 'empty_message', 'Users', 'Colors', 'Sizes', 'Conditions', 'Materials', 'Sections', 'branchs'));

    }

    public function create()
    {
        $page_title = 'Services';
        $empty_message = 'No Result Found';
        $Colors = Color::all();
        $Sizes = Size::with('category')->get();
        $Categories = Category::with('sizes')->get();
        $Conditions = Condition::all();
        $Materials = Material::all();
        $Sections = Section::with('category')->get();
        $branchs = Branch::all();
        $Users = User::all();

        $services = Product::
        with(['color', 'size', 'material', 'condition', 'section', 'branch', 'user', 'categories', 'images'])
            ->latest()->paginate(getPaginate());
        return view('admin.products.create',
            compact('page_title', 'empty_message', 'Colors', 'Categories', 'Users', 'Sizes', 'Conditions', 'Materials', 'Sections', 'branchs'));
    }

    public function createWithSupplier($id)
    {
        $supplier = Supplier::find($id);
        $branch = Auth::guard('admin')->user()->branch;
        $page_title = 'Add Product';
        $empty_message = 'No Result Found';
        $Colors = $branch->colors;
        $Sizes = $branch->sizes;
        $Categories = $branch->categories;
        $Conditions = $branch->conditions;
        $Materials = $branch->materials;
        $Sections = $branch->sections;
        $seasons = $branch->seasons;
        $styles = $branch->styles;
        return view('admin.suppliers.createProduct',
            compact('page_title', 'empty_message', 'Colors',
                'Categories', 'Sizes', 'Conditions',
                'Materials', 'Sections', 'supplier',
                'seasons', 'styles'
            ));
    }

    public function editWithSupplier($supplier,$service)
    {
        $supplier = Supplier::find($supplier);
        $services = Product::with('images')->findOrFail($service);
        $branch = Auth::guard('admin')->user()->branch;
        $page_title = 'Services';
        $empty_message = 'No Result Found';
        $Colors = $branch->colors;
        $Sizes = $branch->sizes;
        $Categories = $branch->categories;
        $Conditions = $branch->conditions;
        $Materials = $branch->materials;
        $Sections = $branch->sections;
        $seasons = $branch->seasons;
        $styles = $branch->styles;

        $services = Product::with('images')->findOrFail($service);
        return view('admin.suppliers.editProduct',
            compact('page_title', 'services','seasons','styles','supplier', 'Categories', 'empty_message', 'Colors', 'Sizes', 'Conditions', 'Materials', 'Sections'));

    }
//    public function createWithSupplier($id)
//    {
//        $supplier = Supplier::find($id);
//        $branch = Auth::guard('admin')->user()->branch;
//        $page_title = 'Add Product';
//        $empty_message = 'No Result Found';
//        $Colors = $branch->colors;
//        $Categories = $branch->categories()->with('sizes')->get();
////        dd($Categories);
////        $Categories = $branch->categories;
//        $Sizes = Size::with('category')->whereHas('category', function ($query) use ($Categories) {
//            $query->whereIn('id', $Categories->pluck('id'));
//        })->get();
//
//        $Sections = Section::with('category')->whereHas('category', function ($query) use ($Categories) {
//            $query->whereIn('id', $Categories->pluck('id'));
//        })->get();
//        $Conditions = $branch->conditions;
//        $Materials = $branch->materials;
//        $seasons = $branch->seasons;
//        $styles = $branch->styles;
//        return view('admin.suppliers.createProduct',
//            compact('page_title', 'empty_message', 'Colors',
//                'Categories', 'Sizes', 'Conditions',
//                'Materials', 'Sections', 'supplier',
//                'seasons', 'styles'
//            ));
//    }

    public function storeWithSupplier(Request $request, $id)
    {
        $supplier = Supplier::find($id);
        $branchAdmin = Auth::guard('admin')->user();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'images' => 'array',
            'images.*' => 'mimes:jpg,jpeg,png,bmp|max:2000',
            'section_id' => 'required|exists:sections,id',
            'category_id' => 'required|exists:categories,id',
            'size_id' => 'required|exists:sizes,id',
            'material_id' => 'required|exists:materials,id',
            'season_id' => 'required|exists:seasons,id',
            'status' => 'required',
            'description' => 'nullable|string',
            'color_id' => 'required|exists:colors,id',
            'condition_id' => 'required|exists:conditions,id',
            'style_id' => 'required|exists:styles,id',
            'buy_price' => 'required',
            'price' => 'required',
            'sell_price' => 'required',
        ]);
        if ($validator->fails()) {
            $notify[] = ['error', 'validation'];
            return back()->withNotify($notify);
        }
        $product = new Product();
        $product->name = $request->input('name');
        $product->section_id = $request->input('section_id');
        $product->category_id = $request->input('category_id');
        $product->size_id = $request->input('size_id');
        $product->material_id = $request->input('material_id');
        $product->season_id = $request->input('season_id');
        $product->status = $request->input('status');
        $product->description = $request->input('description');
        $product->color_id = $request->input('color_id');
        $product->condition_id = $request->input('condition_id');
        $product->style_id = $request->input('style_id');
        $product->buy_price = $request->input('buy_price');
        $product->price = $request->input('price');
        $product->sell_price = $request->input('sell_price');
        $product->barcode = $request->input('barcode');
        $product->location = '';
        $product->user_id = $branchAdmin->id;
        $product->supplier_id = $supplier->id;
        $product->branch_id = $branchAdmin->branch_id;
        $product->is_for_sale = '0';
        $product->save();
        $product->update([
            'sku' => GenerateSkuAction::execute($product->branch_id, $product->section_id, $request->category_id, $product->id)
        ]);
        $product->categories()->attach($request->category_id);
        if (isset($request['images'])) {
            foreach ($request->file('images') as $image) {
                $path = imagePath()['service']['path'];
                $size = imagePath()['service']['size'];
                $filename = $image;

                $filename = uploadImage($image, $path, $size, $filename);
                $product->images()->create([
                    'path' => $filename,
                ]);
            }
        }
        $notify[] = ['success', 'Product added!'];

        return redirect()->route('admin.suppliers.show', $supplier->id)->withNotify($notify);
    }
    public function updateWithSupplier(Request $request, $sup_id,$product)
    {
        $supplier = Supplier::find($sup_id);
        $branchAdmin = Auth::guard('admin')->user();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'images' => 'array',
            'images.*' => 'mimes:jpg,jpeg,png,bmp|max:2000',
            'section_id' => 'required|exists:sections,id',
            'category_id' => 'required|exists:categories,id',
            'size_id' => 'required|exists:sizes,id',
            'material_id' => 'required|exists:materials,id',
            'season_id' => 'required|exists:seasons,id',
            'status' => 'required',
            'description' => 'nullable|string',
            'color_id' => 'required|exists:colors,id',
            'condition_id' => 'required|exists:conditions,id',
            'style_id' => 'required|exists:styles,id',
            'buy_price' => 'required',
            'price' => 'required',
            'sell_price' => 'required',
        ]);
        if ($validator->fails()) {
            $notify[] = ['error', 'validation'];
            return back()->withNotify($notify);
        }
        $product = Product::find($product);
        $product->name = $request->input('name');
        $product->section_id = $request->input('section_id');
        $product->category_id = $request->input('category_id');
        $product->size_id = $request->input('size_id');
        $product->material_id = $request->input('material_id');
        $product->season_id = $request->input('season_id');
        $product->status = $request->input('status');
        $product->description = $request->input('description');
        $product->color_id = $request->input('color_id');
        $product->condition_id = $request->input('condition_id');
        $product->style_id = $request->input('style_id');
        $product->buy_price = $request->input('buy_price');
        $product->price = $request->input('price');
        $product->sell_price = $request->input('sell_price');
        $product->barcode = $request->input('barcode');
        $product->location = '';
        $product->user_id = $branchAdmin->id;
        $product->supplier_id = $supplier->id;
        $product->branch_id = $branchAdmin->branch_id;
        $product->is_for_sale = '0';
        $product->save();
        $product->update([
            'sku' => GenerateSkuAction::execute($product->branch_id, $product->section_id, $request->category_id, $product->id)
        ]);
        $product->categories()->attach($request->category_id);
        if (isset($request['images'])) {
            foreach ($request->file('images') as $image) {
                $path = imagePath()['service']['path'];
                $size = imagePath()['service']['size'];
                $filename = $image;

                $filename = uploadImage($image, $path, $size, $filename);
                $product->images()->create([
                    'path' => $filename,
                ]);
            }
        }
        $notify[] = ['success', 'Product added!'];

        return redirect()->route('admin.suppliers.show', $supplier->id)->withNotify($notify);
    }

    public function deleteImage($id)
    {
        $image = Image::findOrFail($id);
        if (File::exists(public_path($image))) {
            File::delete(public_path('upload/bio.png'));
        }
        $image->delete();
        $notify[] = ['success', 'Status updated!'];
        return back()->withNotify($notify);
    }

    public function insertInInvoices($product)
    {
        InvoicesProdect::create([
            'product_id' => $product->id,
            'price' => $product->price,
            'status' => $product->status,
            'date_of_process' => now(),
        ]);
    }

    public function SaleOrRent($id)
    {
        $product = Product::find($id);

        if ($product->is_for_sale) {
            $product->update(['status' => 'sale']);
            $this->insertInInvoices($product);
            if ($product->user) {
                $this->send_event_notification($product->user, '', ' تم تغيير حالة منتجك الى بيع ', 'Your product status has been changed to Sold');
            }
        } else {
            $product->update(['status' => 'rent']);
            $this->insertInInvoices($product);
            if ($product->user) {
                $this->send_event_notification($product->user, '', ' تم تغيير حالة منتجك الى بيع ', 'Your product status has been changed to Sold');
            }
        }

        $notify[] = ['success', 'Status updated!'];
        return back()->withNotify($notify);
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);

        categoryProduct::where('product_id', $id)->delete();
        InvoicesProdect::where('product_id', $id)->delete();

        $images = Image::where('imagable_type', 'App\Models\Product')->where('imagable_id', $id)->get();
        foreach ($images as $image) {
            removeFile('assets/images/service/' . $image->path);
        }
        $product->images()->delete();
        $product->delete();
        $notify[] = ['success', 'Service Deleted!'];
        return back()->withNotify($notify);
    }

    public function Filter(Request $request)
    {
        $branch = Auth::guard('admin')->user()->branch_id ?? $request->branch;
        $page_title = 'Products';
        $empty_message = 'No Result Found';
        $services = Product::
        when($request->category, function ($query) use ($request) {
            $query->whereHas('categories', function ($query) use ($request) {
                $query->where('categories.id', $request->category);
            });
        })
            ->when($request->section, function ($query) use ($request) {
                $query->where('section_id', $request->section);
            })
            ->when($branch, function ($query) use ($branch) {
                $query->where('branch_id', $branch);
            })
            ->when($request->sku, function ($query) use ($request) {
                $query->where('sku', 'LIKE', "%$request->sku%");
            })
            ->when($request->is_for_sale, function ($query) use ($request) {
                $query->where('is_for_sale', "$request->is_for_sale");
            })
            ->with(['color', 'size', 'material', 'condition', 'section', 'branch', 'user', 'categories', 'images'])
            ->latest()->paginate(getPaginate());

        $branches = Branch::all();
        $categories = Category::orderBy('name')->get();
        $sections = Section::all();
        return view('admin.products.list',
            compact('page_title', 'services', 'empty_message', 'branches', 'sections', 'categories'));
    }

    public function ditails($id)
    {
        $page_title = 'Services';
        $empty_message = 'No Result Found';
        $item = Product::
        with(['color', 'size', 'material', 'condition', 'section', 'branch', 'user', 'categories', 'images'])
            ->find($id);
        return view('admin.products.details',
            compact('page_title', 'empty_message', 'item'));

    }

    public function QR()
    {
        $page_title = 'Services';
        $empty_message = 'No Result Found';
        return view('admin.QR-and-barcode.index', compact('page_title', 'empty_message'));
    }

    public function SaleOrRentQR($code)
    {
        $product = Product::where('sku', $code)->first();
        if ($product) {
            if ($product->status == "available") {
                if ($product->is_for_sale) {
                    $product->update(['status' => 'sale']);
                    $this->insertInInvoices($product);
                    if ($product->user) {
                        $this->send_event_notification($product->user, '', ' تم تغيير حالة منتجك الى بيع ', 'Your product status has been changed to Sold');
                    }
                } else {
                    $product->update(['status' => 'rent']);
                    $this->insertInInvoices($product);
                    if ($product->user) {
                        $this->send_event_notification($product->user, '', ' تم تغيير حالة منتجك الى بيع ', 'Your product status has been changed to Sold');
                    }
                }

                $notify[] = ['success', 'Status updated!'];
                return back()->withNotify($notify);
            } else {
                $notify[] = ['error', 'Product Not Available!'];
                return back()->withNotify($notify);
            }
        } else {
            $notify[] = ['error', 'Product Not Found!'];
            return back()->withNotify($notify);
        }

    }
}
