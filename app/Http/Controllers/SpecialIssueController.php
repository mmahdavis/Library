<?php

namespace App\Http\Controllers;

use App\Http\Resources\SpecialIssueCollection;
use App\Http\Resources\SpecialIssueResource;
use App\Models\SpecialIssue;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\Tag;
use App\Models\Translator;
use App\Models\Writer;
use Illuminate\Http\Request;

class SpecialIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\SpecialIssueCollection;
     */
    public function index()
    {
        return new SpecialIssueCollection(SpecialIssue::orderByDesc('created_at')->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        return new SpecialIssueResource(SpecialIssue::find($id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // 'category_id' => 'required',
            // 'tag_id' => 'required',
            'slug' => 'required|unique:special_issues|max:8',
            'name' => 'required',
            'price' => 'required',
        ]);
        SpecialIssue::create($validatedData);
        return response()->json($validatedData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, SpecialIssue $specialIssue)
    {
        $validatedData = $request->validate([
            // 'category_id' => 'required',
            // 'tag_id' => 'required',
            'slug' => 'required|max:8|unique:special_issues,slug,' . $request->slug . ',slug',
            'name' => 'required',
            'price' => 'required',
        ]);
        $specialIssue->update($validatedData);
        return response()->json($specialIssue);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy(SpecialIssue $specialIssue)
    {
        $specialIssue->delete();
        return response()->json('deleted');
    }
}
