<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return new CategoryCollection(Category::orderByDesc('created_at')->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        return new CategoryResource(Category::find($id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories',
        ]);
        Category::create($validatedData);
        return response()->json($validatedData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,' . $request->slug . ',slug',
        ]);
        $category->update($validatedData);
        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json('deleted');
    }
}
