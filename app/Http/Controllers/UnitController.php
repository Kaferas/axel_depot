<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Requests\UnitRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $unit = $request->query('searchUnit');
        if ($unit) {
            $units = Unit::query()->where('name_unit', 'like', "%{$unit}%")
                // ->orWhere('description_unit', 'like', "%{$unit}%")
                ->where("deleted_status", 0)->get();
        } else {
            $units = Unit::where("deleted_status", 0)->paginate(30);
        }
        return view(
            "logistique_immobilisation/units/index",
            [
                'units' => $units,
                'unit' => $unit,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("logistique_immobilisation/units/create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitRequest $request)
    {
        Unit::create($request->validated());
        return redirect()->route('units.index')->with('success', "Unite de Mesure cree avec Success");
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
    public function update(Request $request, $id)
    {
        $uniteMesure = $request->data[1]['value'];
        $descriptionMesure = $request->data[2]['value'];
        $unit = Unit::find($id);
        $update = $unit->update([
            'name_unit' => $uniteMesure,
            'description_unit' => $descriptionMesure,
            'updated_at' => date("Y-m-d h:m:i")
        ]);
        if ($update) {
            Session::flash('update', "Unites de mesure mise a Jour");
            return Response::json(['result' => 'ok']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        $is = Unit::where('id', $unit->id)->update(array('deleted_status' => 1));
        if ($is) {
            Session::flash('delete', "Unites de mesure supprime");
            return Response()->json(['ok' => 'success']);
        }
    }
}
