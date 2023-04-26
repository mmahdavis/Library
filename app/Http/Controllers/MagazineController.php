<?php

namespace App\Http\Controllers;

use App\Http\Resources\MagazineCollection;
use App\Http\Resources\MagazineResource;
use App\Models\Magazine;
use Illuminate\Http\Request;

class MagazineController extends Controller
{
    public function index()
    {
        return new MagazineCollection(Magazine::orderByDesc('created_at')->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        return new MagazineResource(Magazine::find($id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'required',
            'name' => 'required',
            'slug' => 'required|unique:magazines',
            'price' => 'required',
        ]);
        Magazine::create($validatedData);
        return response()->json($validatedData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, Magazine $magazine)
    {
        $validatedData = $request->validate([
            'image' => 'required',
            'name' => 'required',
            'slug' => 'required|unique:magazines,slug,' . $request->slug . ',slug',
            'price' => 'required'
        ]);
        $magazine->update($validatedData);
        return response()->json($magazine);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy(Magazine $magazine)
    {
        $magazine->delete();
        return response()->json('deleted');
    }
}
