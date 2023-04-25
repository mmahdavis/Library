<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\BookCollection;
     */
    public function index()
    {
        return new BookCollection(Book::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        return new BookResource(Book::find($id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_id' => 'required',
            'tag_id' => 'required',
            'publisher_id' => 'required',
            'translator_id' => 'required',
            'writer_id' => 'required',
            'code' => 'required|unique:books|max:8',
            'name' => 'required',
            'price' => 'required',
            'image' => 'required',
        ]);
        Book::create($validatedData);
        return response()->json($validatedData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, Book $book)
    {
        $validatedData = $request->validate([
            'category_id' => 'required',
            'tag_id' => 'required',
            'publisher_id' => 'required',
            'translator_id' => 'required',
            'writer_id' => 'required',
            'code' => 'required|max:8|unique:books,code,' . $request->code . ',code',
            'name' => 'required',
            'price' => 'required',
            'image' => 'required',
        ]);
        $book->update($validatedData);
        return response()->json($book);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json('deleted');

    }
}
