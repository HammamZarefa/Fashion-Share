<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\GenerateSkuAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductsListRequest;
use App\Http\Resources\ProductResource;
use App\Models\AdminNotification;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * GET Category Products
     *
     * Returns paginated list of Products by category id.
     *
     * @urlParam Category_slug string Category Id. Example: "3"
     *
     * @bodyParam priceFrom number. Example: "123.45"
     * @bodyParam priceTo number. Example: "234.56"
     * @bodyParam dateFrom date. Example: "2023-06-01"
     * @bodyParam dateTo date. Example: "2023-07-01"
     * @bodyParam sortBy string. Example: "price"
     * @bodyParam sortOrder string. Example: "asc" or "desc"
     *
     * @response {"data":[{"id":"9958e389-5edf-48eb-8ecd-e058985cf3ce","name":"Product on Sunday","starting_date":"2023-06-11","ending_date":"2023-06-16","price":"99.99"},{"id":"9958e389-5edf-48eb-8ecd-e058985cf3c2","name":"Product on Tuesday","starting_date":"2023-06-14","ending_date":"2023-06-19","price":"119.99"},{"id":"9958e389-5edf-48eb-8ecd-e058985cf3c1","name":"Product on Monday","starting_date":"2023-06-18","ending_date":"2023-06-23","price":"79.99"}],"links":{"first":"http://Category-api.test/api/v1/Categorys/first-Category/Products?page=1","last":"http://Category-api.test/api/v1/Categorys/first-Category/Products?page=1","prev":null,"next":null},"meta":{"current_page":1,"from":1,"last_page":1,"links":[{"url":null,"label":"&laquo; Previous","active":false},{"url":"http://Category-api.test/api/v1/Categorys/first-Category/Products?page=1","label":"1","active":true},{"url":null,"label":"Next &raquo;","active":false}],"path":"http://Category-api.test/api/v1/Categorys/first-Category/Products","per_page":15,"to":3,"total":3}}
     *
     */
    public function index(ProductsListRequest $request)
    {
        $products = Product::available()
            ->with(['color', 'size', 'material', 'condition', 'section', 'branch', 'user', 'category', 'images'])
            ->when($request->size, function ($query) use ($request) {
                $query->where('size_id', $request->size);
            })
            ->when($request->color, function ($query) use ($request) {
                $query->where('color_id', $request->color);
            })
            ->when($request->priceFrom, function ($query) use ($request) {
                $query->where('sell_price', '>=', $request->priceFrom);
            })
            ->when($request->priceTo, function ($query) use ($request) {
                $query->where('sell_price', '<=', $request->priceTo);
            })
            ->when($request->condition, function ($query) use ($request) {
                $query->where('condition_id', $request->condition);
            })
            ->when($request->material, function ($query) use ($request) {
                $query->where('material_id', $request->material);
            })
            ->when($request->section, function ($query) use ($request) {
                $query->where('section_id', $request->section);
            })
            ->when($request->branch, function ($query) use ($request) {
                $query->where('branch_id', $request->branch);
            })
            ->when($request->sale, function ($query) use ($request) {
                $query->where('is_for_sale', $request->sale);
            })
            ->when($request->category, function ($query) use ($request) {
                $query->where('category_id', $request->category);
            })
            ->when($request->sortBy, function ($query) use ($request) {
                if (!in_array($request->sortBy, ['sell_price', 'created_at'])
                    || (!in_array($request->sortOrder, ['asc', 'desc']))) {
                    return;
                }
                $query->orderBy($request->sortBy, $request->sortOrder);
            })
            ->where(function ($query) {
                $query->whereHas('supplier', function ($subquery) {
                    $subquery->where('email', 'NOT LIKE', '%@permenent.com');
                })
                    ->orWhereDoesntHave('supplier');
            })
            ->orderBy('id', 'desc')
            ->paginate();
        return ProductResource::collection($products);
    }

    public function show(Product $product)
    {
        $product->with(['color', 'size', 'material', 'condition', 'section', 'branch', 'user', 'categories', 'images']);
        return ProductResource::make($product);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable',
            'buy_price' => 'nullable',
            'sell_price' => 'nullable',
            'category_id' => 'nullable|exists:categories,id',
            'color_id' => 'nullable|exists:colors,id',
            'material_id' => 'nullable|exists:materials,id',
            'section_id' => 'nullable|exists:sections,id',
            'size_id' => 'nullable|exists:sizes,id',
            'condition_id' => 'nullable|exists:conditions,id',
            'branch_id' => 'required|exists:branches,id',
            'is_for_sale' => 'nullable',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'location' => 'nullable|string',
            'season_id' => 'nullable|exists:seasons,id',
            'style_id' => 'nullable|exists:styles,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'barcode' => 'nullable|numeric|min:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages(), 'status' => 400], 400);
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
            'is_for_sale' => $request->input('is_for_sale'),
            'location' => $request->input('location'),
            'buy_price' => $request->input('buy_price'),
            'sell_price' => $request->input('sell_price'),
            'season_id' => $request->input('season_id'),
            'style_id' => $request->input('style_id'),
            'supplier_id' => $request->input('supplier_id'),
            'barcode' => $request->input('barcode'),
        ]);
        $product->update ([
            'sku' => GenerateSkuAction::execute($product->branch_id, $product->section_id, $request->category_id, $product->id)
        ]) ;
        if ($request->hasFile('images')) {
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

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->id();
        $adminNotification->title = 'New product request ';
        $adminNotification->click_url = url('admin/services/details', $product->id);
        $adminNotification->save();
        return response()->json(['message' => 'Product created successfully', 'data' => $product, 'status' => 201]);
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'description' => 'nullable|string',
            'price' => 'numeric',
            'buy_price' => 'nullable',
            'sell_price' => 'nullable',
            'category_id' => 'exists:categories,id',
            'color_id' => 'exists:colors,id',
            'material_id' => 'exists:materials,id',
            'section_id' => 'exists:sections,id',
            'size_id' => 'exists:sizes,id',
            'condition_id' => 'exists:conditions,id',
            'branch_id' => 'exists:branches,id',
            'is_for_sale' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'location' => 'nullable|string',
            'season_id' => 'nullable|exists:seasons,id',
            'style_id' => 'nullable|exists:styles,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'barcode' => 'nullable|numeric|min:10',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages(), 'status' => 400], 400);
        }

        $product->update($request->only([
            'name',
            'description',
            'price',
            'buy_price',
            'sell_price',
            'category_id',
            'color_id',
            'material_id',
            'section_id',
            'size_id',
            'condition_id',
            'branch_id',
            'is_for_sale',
            'location',
            'season_id',
            'style_id',
            'supplier_id',
            'barcode',
        ]));
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('public/images', $filename);

                // Create or update the image record in the database
                $product->images()->create([
                    'path' => 'images/' . $filename,
                    // Add other image fields as needed
                ]);
            }
        }

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->id();
        $adminNotification->title = 'Product updated ';
        $adminNotification->click_url = urlPath('admin.services.edit', $product->id);
        $adminNotification->save();
        return response()->json(['message' => 'Product updated successfully', 'data' => $product, 'status' => 200]);
    }

    public function FilterNameDescription($NameDescription = null){
        $products = Product::available()
            ->with(['color', 'size', 'material', 'condition', 'section', 'branch', 'user', 'category', 'images'])
            ->when($NameDescription, function ($query) use ($NameDescription) {
                $query->where('name','LIKE', "%$NameDescription%")
                    ->OrWhere('description','LIKE', "%$NameDescription%");
            })
            ->where(function ($query) {
                $query->whereHas('supplier', function ($subquery) {
                    $subquery->where('email', 'NOT LIKE', '%@permenent.com');
                })
                    ->orWhereDoesntHave('supplier');
            })
            ->orderBy('id', 'desc')
            ->paginate();
        return ProductResource::collection($products);
    }
}
