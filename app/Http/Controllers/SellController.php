<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Commande_details;
use App\Models\Paiements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

use function App\Helpers\generateInvoiceNumber;
use function App\Helpers\getStoreId;
use function App\Helpers\getStores;

class SellController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $store = getStoreId();
        $articles = DB::table('articles_' . $store . '_store as st')->Join('categories', 'categories.id', '=', 'st.categorie_id')
            ->select("st.*", "categories.nom_categorie", "categories.color_categorie")
            ->where("st.deleted_status", 0)
            ->get();
        $clients = DB::table("clients")->where("deleted_status", 0)->get();
        return view("sells.index", ['articles' => $articles, "clients" => $clients]);
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
        $store = getStoreId();
        $client = $_POST['client'];
        $quantity = $_POST['qty'];
        $codebar = $_POST['codebar'];
        $price = $_POST['price'];
        $article_name = $_POST['nameArt'];
        $mode = $_POST['mode'];
        $avance = empty($_POST['avance']) ? 0 : $_POST['avance'];
        $casePaid = $_POST['casePaid'];
        $commande_code = $this->generateCommandeNumber();
        $invoiceNumber = $casePaid == "commande" ? "" : generateInvoiceNumber();
        $user = Auth::user()->id;
        $global = 0;
        $details = [];
        for ($i = 0; $i < count($quantity); $i++) {
            array_push($details, [
                "commande_code" => $commande_code,
                "ref_produit" => $codebar[$i],
                "quantity" => $quantity[$i],
                "price_product" => $price[$i],
                "name_produit" => $article_name[$i],
                "total_details" => $quantity[$i] * $price[$i],
                "created_by" => $user
            ]);
            $global += $quantity[$i] * $price[$i];
            $current = DB::table("articles_" . $store . "_store")->select("quantite")->where("codebar_article", $codebar[$i])->get()->first();

            DB::table("articles_" . $store . "_store")->where("codebar_article", $codebar[$i])->update([
                'quantite' => intval($current->quantite) - intval($quantity[$i]),
            ]);
        }
        Commande_details::insert($details);
        Commande::create([
            "invoice_number" => $invoiceNumber,
            "commande_code" => $commande_code,
            "client_id" => $client,
            "amount_commande" => $global,
            "avance_amount" => $avance,
            "type_paie" => $mode,
            "depot_id" => $store,
            "created_by" => $user,
        ]);
        if ($casePaid == "paie") {
            Paiements::create([
                "commande_code" => $commande_code,
                "montant_paiement" => $global,
                "mode_paiement" => $mode,
                "client_id" => $client,
                "depot_id" => $store,
                "avance" => $avance,
                "created_by" => $user
            ]);
        }
        return Response::json(['result' => 'ok']);
    }




    public function generateCommandeNumber($length = 7)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
