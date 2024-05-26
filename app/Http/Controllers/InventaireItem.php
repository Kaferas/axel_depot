<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventaireItemsModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class InventaireItem extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InventaireItemsModel $inventaires_detail)
    {
        // dd($request->modPrice);
        $up_inventory = $inventaires_detail->update([
            'price_inventaire' => $request->modPrice * $request->modQty,
            'qty_physique_inventaire' => $request->modQty,
            'qty_theorique_inventaire' => $request->modQtyTh,
            'price_article' => $request->modPrice,
            'difference_inventaire' =>  $request->modQtyTh - $request->modQty,
            'modified_by' => Auth::user()->id,
            'modified_at' => date('Y-m-d h:m:i'),
        ]);
        if ($up_inventory) {
            return Response::json(['result' => 'ok']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $inv_items = InventaireItemsModel::find($id);
        $reason = $request->reason;
        $inv_items->update([
            'status_inventaire' => 2,
            'modified_by' => Auth::user()->id,
            'modified_at' => date('Y-m-d h:m:i'),
            'reason_delete' => $reason
        ]);
        return response()->json(['success' => 'Detaild Deleted Successfully!']);
    }
}
