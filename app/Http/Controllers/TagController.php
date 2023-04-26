<?php

namespace App\Http\Controllers;

use App\Http\Resources\TagCollection;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        return new TagCollection(Tag::orderByDesc('created_at')->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        return new TagResource(Tag::find($id));
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
            'slug' => 'required|unique:tags',
        ]);
        Tag::create($validatedData);
        return response()->json($validatedData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, Tag $tag)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:tags,slug,' . $request->slug . ',slug',
        ]);
        $tag->update($validatedData);
        return response()->json($tag);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response()->json('deleted');
    }
}
