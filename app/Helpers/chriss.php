<?php

namespace App\Helpers;

use App\Models\Commande;
use App\Models\Depot;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;

function goog()
{
    dd("Je suis un Millionaire");
}

function getStores()
{
    return Depot::stores();
}

function getMode($id)
{
    $mode = "";
    if ($id == 1) {
        $mode = "Cash";
    }
    if ($id == 2) {
        $mode = "Credit";
    }
    if ($id == 3) {
        $mode = "Cheque Bancaire";
    }
    if ($id == 4) {
        $mode = "Avance";
    }
    return $mode;
}

function getStoreId()
{
    return session("currentStore") ?? allowedStore()[0];
}

function allowedStore()
{
    if (Auth::user()->isAdmin()) {
        return Depot::all()->map->id->toArray();
    } else {
        return [User::where("id", Auth::user()->id)->first()->depot];
    }
}

function roleName()
{
    if (Auth::user()->isAdmin()) {
        return "ADMIN";
    } else if (Auth::user()->isCaissier()) {
        return "CAISSIER";
    } else {
        return "GERANT";
    }
}


function generateInvoiceNumber()
{
    $store = getStoreId();
    $codeCommande = Commande::where("depot_id", $store)->whereNotNull('invoice_number')->orderBy("id", "DESC")->get();
    if (!empty($codeCommande)) {
        $code = empty($codeCommande->first()->invoice_number) ? "F-00000" : $codeCommande->first()->invoice_number;
        $code = explode("-", $code);
        $code = intval($code[1]) + 1;
        $code = "F-" . str_pad($code, 5, "0", STR_PAD_LEFT);
        $codeCommande->invoice_number = $code;
    } else {
        $codeCommande->invoice_number = "F-00001";
    }
    return $codeCommande->invoice_number;
}

function getStoreName($id)
{
    return Depot::getStoreName($id);
}