<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Models\ApiProvider;
use App\Models\Category;
use App\Models\GeneralSetting;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\Null_;

class ServiceController extends Controller
{
    public function index()
    {
        $page_title = 'Services';
        $empty_message = 'No Result Found';
        $categories = Category::orderBy('name')->get();
        $services = Product::
        with(['color', 'size', 'material', 'condition', 'section', 'branch', 'user', 'categories', 'images'])
            ->latest()->paginate(getPaginate());
        return view('admin.products.list', compact('page_title', 'services', 'empty_message', 'categories'));
    }

    public function store(StoreServiceRequest $request)
    {
        $service = new Product();
        $this->serviceAction($service, $request);

        $image = $request->file('image');
        $path = imagePath()['service']['path'];
        $size = imagePath()['service']['size'];
        $filename = $request->image;
        if ($request->hasFile('image')) {
            try {
                $filename = uploadImage($image, $path, $size, $filename);
//                    dd($filename);
            } catch (\Exception $exp) {
                $notify[] = ['errors', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
            $service->image = $filename;
        }
        $service->save();

        $notify[] = ['success', 'Service added!'];
        return back()->withNotify($notify);
    }

    public function update(Request $request, $id)
    {

        $service = Service::findOrFail($id);
        $this->serviceAction($service, $request);
        $image = $request->file('image');
        $path = imagePath()['service']['path'];
        $size = imagePath()['service']['size'];
        $filename = $request->image;
        if ($request->hasFile('image')) {
            try {
                $filename = uploadImage($image, $path, $size, $filename);
//                    dd($filename);
            } catch (\Exception $exp) {
                $notify[] = ['errors', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
            $service->image = $filename;
        }
        $service->save();

        $notify[] = ['success', 'Service updated!'];
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
}
