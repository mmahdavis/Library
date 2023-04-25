<?php

namespace App\Http\Controllers;

use App\Http\Resources\WriterCollection;
use App\Models\Writer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WriterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\WriterCollection;
     */
    public function index()
    {
        return new WriterCollection(Writer::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
    }
}
