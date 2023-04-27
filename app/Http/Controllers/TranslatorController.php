<?php

namespace App\Http\Controllers;

use App\Http\Resources\TranslatorCollection;
use App\Http\Resources\TranslatorResource;
use App\Models\Translator;
use Illuminate\Http\Request;

class TranslatorController extends Controller
{
    public function index()
    {
        return new TranslatorCollection(Translator::orderByDesc('created_at')->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        return new TranslatorResource(Translator::find($id));
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
            'slug' => 'required|unique:translators',
        ]);
        Translator::create($validatedData);
        return response()->json($validatedData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, Translator $translator)
    {
        $validatedData = $request->validate([
            'image' => 'required',
            'name' => 'required',
            'slug' => 'required|unique:translators,slug,' . $request->slug . ',slug',
        ]);
        $translator->update($validatedData);
        return response()->json($translator);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy(Translator $translator)
    {
        $translator->delete();
        return response()->json('deleted');
    }
}
