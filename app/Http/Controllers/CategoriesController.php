<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Http\Requests\StoreCategoriesRequest;
use App\Http\Requests\UpdateCategoriesRequest;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categories::where('deleted_status', 0)->get();
        return view("categories.index", ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("categories.add");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriesRequest $request)
    {
        Categories::create($request->validated());
        return redirect("/categories")->with("success", "Categorie cree avec Success");
    }

    /**
     * Display the specified resource.
     */
    public function show(Categories $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categories $category)
    {
        //
        return view("categories.edit", ['categorie' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoriesRequest $request, Categories $category)
    {
        $category->update($request->validated());
        return redirect("/categories")->with("update", "Categorie mise a Jour avec Success");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categories $category)
    {
        $category->update(['deleted_status' => 1]);
        return redirect("/categories")->with("delete", "Categorie Supprime avec Success");
    }
}
