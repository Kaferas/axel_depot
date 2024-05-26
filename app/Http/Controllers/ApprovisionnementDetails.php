<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Models\ApprovisionnementDetails as  MyApprovisionnementDetails;

class ApprovisionnementDetails extends Controller
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
    public function update(Request $request, MyApprovisionnementDetails $detail)
    {
        $up_detail = $detail->update([
            'price_article' => $request->modPrice,
            'qty_article' => $request->modQty,
            'total_article' => $request->modQty * $request->modPrice,
            'modified_by' => Auth::user()->id,
            'modified_at' => date('Y-m-d h:m:i'),
        ]);
        if ($up_detail) {
            return Response::json(['result' => 'ok']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, MyApprovisionnementDetails $detail)
    {
        $reason = $request->reason;
        // dd($detail);
        $detail->update([
            'status_approv' => 2,
            'modified_by' => Auth::user()->id,
            'modified_at' => date('Y-m-d h:m:i'),
            'reason_delete' => $reason
        ]);
        return response()->json(['success' => 'Detaild Deleted Successfully!']);
    }
}
