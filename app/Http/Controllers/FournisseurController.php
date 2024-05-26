<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use App\Http\Requests\StoreFournisseurRequest;
use App\Http\Requests\UpdateFournisseurRequest;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fournisseurs = Fournisseur::where('deleted_status', 0)->get();
        return view("fournisseurs.index", ['fournisseurs' => $fournisseurs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("fournisseurs.add");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFournisseurRequest $request)
    {
        Fournisseur::create($request->validated());
        return redirect("/fournisseurs")->with('success', 'Fournisseur cree avec Success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Fournisseur $fournisseur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fournisseur $fournisseur)
    {
        return view("fournisseurs.edit", ['fournisseur' => $fournisseur]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreFournisseurRequest $request, Fournisseur $fournisseur)
    {
        $fournisseur->update($request->validated());
        return redirect("/fournisseurs")->with('update', 'Fournisseur mise a jour avec Success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fournisseur $fournisseur)
    {
        $fournisseur->update(['deleted_status' => 1]);
        return redirect("/fournisseurs")->with('delete', 'Fournisseur supprime avec Success');
    }
}
