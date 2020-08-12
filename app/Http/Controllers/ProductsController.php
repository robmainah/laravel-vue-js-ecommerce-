<?php

namespace App\Http\Controllers;

use DB;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests;
// use Illuminate\Http\File;


use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductsRequest;
use App\Category;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * Administrator side
     */
    public function create()
    {
        $product = Product::latest()->get();
        // $product = DB::table('products')
        //     ->join('categories', 'products.category_id', '=', 'categories.id')
        //     ->join('users', 'products.updated_by', '=', 'users.id')
        //     ->select(
        //         'products.id',
        //         'productId',
        //         'title',
        //         'description',
        //         'price',
        //         'quantity',
        //         'image',
        //         'products.updated_at',
        //         'category_name as category',
        //         'name as user'
        //     )
        //     ->whereNull('products.deleted_at')
        //     ->latest('products.created_at')
        //     ->orderBy('title')
        //     ->get();

        return response()->json($product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductsRequest $request)
    {
        $prod = new Product;

        $prod->productId = Product::generateProductNumber();
        $prod->category_id = $request->category;
        // $prod->categoryId = 356;
        $prod->title =  ucfirst($request->title);
        $prod->description = $request->description;
        // $prod->imageAlt = ucfirst($request->imageAlt);
        $prod->price = $request->price;
        $prod->quantity = $request->quantity;
        $prod->created_by = auth()->user()->id;
        $prod->updated_by = auth()->user()->id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($name = $image->store($request->title, "public")) {
                $prod->image = $name;
                //TODO ===== prevent storing images if data was not entered in database
                $prod->save();

                return response()->json(['success' => "Product added successfully..", 'addedProduct' => $prod]);
            }
        }

        return response()->json(['errors' => "Failed to add product..Try again!!!!"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {

        // return view('index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductsRequest $request)
    {
        $prod = Product::findOrFail($request->id);
        // return $prod;

        // $prod->productId = rand(111111, 999999);
        $prod->category_id = Category::where('category_name', $request->category)->pluck('id')[0];
        $prod->title =  ucfirst($request->title);
        $prod->slug =  str_slug($request->title);
        $prod->description = $request->description;
        $prod->price = $request->price;
        $prod->quantity = $request->quantity;
        $prod->updated_by = auth()->user()->id;

        $oldImagename = explode('/', $prod->image)[1];

        $newImageName = "";

        if ($request->image) {
            $newImageName = $request->file('image')->getClientOriginalName();
        }

        if ($oldImagename !== $newImageName) {
            if ($request->hasFile('image')) {
                // $image = $request->file('image');

                if ($name = $request->file('image')->store(str_slug($request->title), "public")) {
                    $prod->image = $name;
                    //TODO ===== prevent storing images if data was not entered in database
                    //TODO ===== rename the folders if the title changes
                    $prod->save();

                    return response()->json(['success' => "Product updated successfully", 'addedProduct' => $prod]);
                }
            }
        }

        if ($prod->save()) {
            return response()->json(['success' => "Product updated successfully"]);
        }

        return response()->json(['errors' => "Failed to update..Try again!!!!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    /* Request $request */
    public function destroy($product)
    {

        // $request = Product::destroy(collect($request));
        $execute = Product::destroy(explode(",", $product));

        if ($execute) {
            return response()->json(['success' => "Deleted successfully!!!!!"]);
        }

        return response()->json(['error' => "Error!!! Failed to delete try again"]);
    }
}