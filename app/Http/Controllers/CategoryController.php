<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProductCategoryModel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = ProductCategoryModel::all(); 
        return Inertia::render('Category/Category', [
            'category' => $category
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Category/CategoryAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate([
            'name'  => 'required|string|max:255| unique:product_category_models'
        ]);

        ProductCategoryModel::create([
            'name' => $request -> name
        ]);

        return redirect() -> to(route('category.index')) -> with('message', 'Category created successfull');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategoryModel $category)
    {
        return Inertia::render('Category/CategoryEdit', [
            'category'  => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategoryModel $category)
    {
        $request -> validate([
            'name'  => 'required|string|max:255'
        ]);


        $category ->update([
            'name' => $request -> name
        ]);

        return redirect() -> to(route('category.index')) -> with('message', 'Category Updated successfull');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategoryModel $category)
    {
        $category -> delete();

        return redirect() -> to(route('category.index')) -> with('message', 'Category Deleted successfull');
    }
}
