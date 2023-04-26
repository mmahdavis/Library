<?php

namespace App\Http\Controllers;

use App\Http\Resources\PublisherCollection;
use App\Http\Resources\PublisherResource;
use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function index()
    {
        return new PublisherCollection(Publisher::orderByDesc('created_at')->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        return new PublisherResource(Publisher::find($id));
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
            'slug' => 'required|unique:publishers',
        ]);
        Publisher::create($validatedData);
        return response()->json($validatedData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, Publisher $publisher)
    {
        $validatedData = $request->validate([
            'image' => 'required',
            'name' => 'required',
            'slug' => 'required|unique:publishers,slug,' . $request->slug . ',slug',
        ]);
        $publisher->update($validatedData);
        return response()->json($publisher);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();
        return response()->json('deleted');
    }
}
