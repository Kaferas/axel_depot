<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Paiements;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function App\Helpers\generateInvoiceNumber;
use function App\Helpers\getStoreId;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $store = getStoreId();
        $invoices = DB::table("commandes as co")
            ->join("clients", 'clients.id', 'co.client_id')
            ->select("co.*", "clients.name_client", "clients.prenom_client")
            ->where("co.depot_id", $store)
            ->orderBy("created_at", "DESC")
            ->get();
        return view("invoices.index", ['invoices' => $invoices]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $invoice = Commande::where("commandes.id", $id)
            ->join("clients", 'clients.id', 'commandes.client_id')
            ->join("users", 'users.id', 'commandes.created_by')
            ->join("commandes_details", 'commandes_details.commande_code', 'commandes.commande_code')
            ->get();
        return view("invoices.view", ['invoice' => $invoice]);
    }


    public function paidReste()
    {
        $current_invoice_number = generateInvoiceNumber();
        $from_view = $_POST['data_post'];
        $store = getStoreId();
        Paiements::insert([
            'commande_code' => $from_view['commande'],
            'montant_paiement' => $from_view['reste'],
            'mode_paiement' => $from_view['mode'],
            'client_id' => $from_view['client'],
            'avance' => $from_view['reste'] == $from_view['amount'] ? 0 : $from_view['amount'],
            'depot_id' => $store,
            'created_by' => Auth::user()->id
        ]);
        if ($from_view['reste'] == $from_view['amount']) {
            Commande::where("commande_code", $from_view['commande'])->update(['type_paie' => 1]);
        }
        Commande::where("commande_code", $from_view['commande'])->update(['invoice_number' => $current_invoice_number, 'avance_amount' => $from_view['reste'] == $from_view['amount'] ? 0 : $from_view['amount']]);
        return response()->json(['result' => 'ok']);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function paid(string $commande)
    {
        $paiements = Paiements::where("commande_code", $commande)->with("clients")->get();
        $command = Commande::where("commande_code", $commande)->with("clients")->get();
        $way = "";
        if (count($paiements) > 0) {
            $paiements = $paiements;
            $way = "paiements";
        } else {
            $paiements = $command;
            $way = "commande";
        }
        if (count($paiements) > 0 and $way == "paiements") {
            $commande_global_total = Paiements::where("commande_code", $commande)->first()->montant_paiement;
            $commande_total_paid = Paiements::where("commande_code", $commande)->sum("avance");
            $reste_to_pay = $commande_global_total - $commande_total_paid;
        } else {
            $reste_to_pay = $paiements->first()->amount_commande;
        }
        return view("invoices.paid", ['invoice' => $commande, 'way' => $way, 'paiements' => $paiements, 'reste' => $reste_to_pay]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
