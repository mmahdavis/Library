<?php

namespace App\Http\Controllers;

use App\Http\Resources\WriterCollection;
use App\Http\Resources\WriterResource;
use App\Models\Writer;
use Illuminate\Http\Request;

class WriterController extends Controller
{
    public function index()
    {
        return new WriterCollection(Writer::orderByDesc('created_at')->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        return new WriterResource(Writer::find($id));
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
            'slug' => 'required|unique:writers',
        ]);
        Writer::create($validatedData);
        return response()->json($validatedData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, Writer $writer)
    {
        $validatedData = $request->validate([
            'image' => 'required',
            'name' => 'required',
            'slug' => 'required|unique:writers,slug,' . $request->slug . ',slug',
        ]);
        $writer->update($validatedData);
        return response()->json($writer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy(Writer $writer)
    {
        $writer->delete();
        return response()->json('deleted');
    }
}
