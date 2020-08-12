<?php

namespace App\Http\Controllers;

use DB;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoriesRequest;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
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
     */
    public function create()
    {
        $categories = Category::withCount('product')->latest()->get();
        // $categories = DB::table('categories')
        //     ->join('users', 'categories.updated_by', '=', 'users.id')
        //     ->select(
        //         'categories.id',
        //         'category_name',
        //         'categoryId',
        //         'activated',
        //         'categories.updated_at',
        //         'users.name as user'
        //     )
        //     ->whereNull('categories.deleted_at')
        //     ->get();
        // return auth()->user();
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriesRequest $request)
    {
        $cat = new Category;

        $cat->categoryId = rand(111111, 999999);
        $cat->category_name = ucfirst($request->category_name);
        $cat->activated = ucfirst($request->activated);
        $cat->created_by = auth()->guard('admin')->user()->id;
        $cat->updated_by = Auth::guard('admin')->user()->id;

        $cat->save();

        return response()->json(['success' => "Successfully added!!!", 'addedCategory' => $cat]);
        // return $cat;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show(Category $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriesRequest $request)
    {
        $category = Category::find($request->id);

        $category->category_name = ucfirst($request->category_name);
        $category->activated = $request->activated;
        $category->updated_by = auth()->id();

        if ($category->save()) {
            return response()->json(['success' => "Updated successfully"]);
        }

        return response()->json(['errors' => "Failed to update!!!!!!!!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $category = Category::destroy(collect($request));

        if ($category) {
            return response()->json(['success' => "Deleted Successfully"]);
        }

        return response()->json(['errors' => "Failed to delete"]);
    }
}