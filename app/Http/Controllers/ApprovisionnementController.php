<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Article;
use App\Models\Fournisseur;
use Illuminate\Http\Request;
use App\Models\Approvisionnement;
use App\Models\FlowStockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\ApprovisionnementDetails;
use App\Models\Articles;
use Illuminate\Support\Facades\Response;

use function App\Helpers\getStoreId;

class ApprovisionnementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $store = getStoreId();
        $from = !empty($request->query("from_date")) ? Carbon::createFromFormat("Y-m-d", $request->query("from_date")) : '';
        $to = !empty($request->query("to_date")) ? Carbon::createFromFormat("Y-m-d", $request->query("to_date")) : '';
        $fournisseur = $request->query("fournisseur");
        if ($from && $to && !isset($fournisseur)) {
            $approvisions = DB::table("approvisionnements_" . $store . "_store")->join("users", 'users.id', 'app.created_by')->whereBetween('created_at', [$from, $to])->get();
        } else if ($fournisseur && empty($from) && empty($to)) {
            $approvisions = DB::table("approvisionnements_" . $store . "_store")->join("fournisseurs", 'approvisionnements.approv_fournisseur', 'fournisseurs.id')->join("users", 'users.id', 'app.created_by')->where('fournisseurs.id', $fournisseur)->select("app.*", "fournisseurs.nom_fournisseur", "users.name")->get();
        } else if ($from && $to && $fournisseur) {
            $approvisions = DB::table("approvisionnements_" . $store . "_store")->join("fournisseurs", 'approvisionnements.approv_fournisseur', 'fournisseurs.id')->join("users", 'users.id', 'app.created_by')->where('fournisseurs.id', $fournisseur)->whereBetween('fournisseurs.created_at', [$from, $to])->select("app.*", "fournisseurs.nom_fournisseur", "users.name")->get();
        } else {
            $approvisions = DB::table("approvisionnements_" . $store . "_store as app")->join("users", 'users.id', 'app.created_by')->join("fournisseurs", 'app.approv_fournisseur', 'fournisseurs.id')->select("app.*", "fournisseurs.nom_fournisseur", "users.name")->orderBy('id', 'desc')->paginate(10);
        }
        $suppliers = Fournisseur::orderBy('id', 'desc')->get();
        return view("/approvisionements/index", [
            'approvisions' => $approvisions,
            'suppliers' => $suppliers,
            'fournisseur' => $fournisseur,
            'from' => str_replace("-", "/", $from),
            'to' => str_replace("-", "/", $to),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $store = getStoreId();
        $fournisseurs = DB::table("fournisseurs")->where('deleted_status', 0)->get();
        $articles = DB::table("articles_" . $store . "_store as ar")->Join('categories', 'categories.id', '=', 'ar.categorie_id')->where('ar.deleted_status', 0)->select("ar.*", "categories.color_categorie", "categories.nom_categorie")->get();
        return view("/approvisionements/create", [
            'suppliers' => $fournisseurs,
            'articles' => $articles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $store = getStoreId();
        $title = $_POST['title_approv'];
        $fournisseur = $_POST['fournisseur'];
        $montant = $_POST['montant_approv'];
        $price = $_POST['price'];
        $qty = $_POST['qty'];
        $codebar = $_POST['codebar'];
        $nameArt = $_POST['nameArt'];
        $current_code = $this->generateCodeApprov();
        $user = Auth::user()->id;
        $store = getStoreId();
        DB::table('approvisionnements_' . $store . '_store')->insertGetId(
            array('approv_code' => $current_code, 'approv_title' => $title, 'approv_amount' => $montant, 'approv_fournisseur' => $fournisseur, 'created_by' => $user, 'created_at' => date('d-m-y h:i:s'))
        );
        for ($i = 0; $i < count($codebar); $i++) {
            $out[] = [
                'code_appr' => $current_code,
                'codebar_article' => $codebar[$i],
                'name_article' => $nameArt[$i],
                'qty_article' => $qty[$i],
                'price_article' => $price[$i],
                'total_article' => $price[$i] * $qty[$i],
                'created_by' => $user,
                'created_at' => date('d-m-y h:i:s')
            ];
        }
        $approv_det = DB::table('approvisionnement_' . $store . '_details')->insert($out);
        if ($approv_det) {
            return Response::json(['result' => 'ok']);
        } else {
            return Response::json(['error' => 'ok']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($approvisionnement)
    {
        $store = getStoreId();
        $code = DB::table("approvisionnements_" . $store . "_store")->where('id', $approvisionnement)->get()->first()->approv_code;
        $approv_details = DB::select("SELECT us.name,fou.nom_fournisseur,det.* FROM approvisionnement_" . $store . "_details as det join approvisionnements_" . $store . "_store app ON app.approv_code=det.code_appr join fournisseurs fou on fou.id=app.approv_fournisseur JOIN users us on us.id=det.created_by where code_appr='" . $code . "'");
        // dd($approv_details[0]);
        return view("/approvisionements/view", [
            'approvision' => $approvisionnement,
            'details' => $approv_details,
            'code' => $code
        ]);
    }

    public function confirmerApprov($code)
    {
        $store = getStoreId();
        $current_detail = DB::select("SELECT price_article,codebar_article,qty_article FROM approvisionnement_" . $store . "_details where code_appr='" . $code . "' AND status_approv=0");
        foreach ($current_detail as $detail) {
            $article = DB::table("articles_" . $store . "_store")->where("codebar_article", $detail->codebar_article)->first();
            $newQty = $article->quantite + $detail->qty_article;
            DB::table("articles_" . $store . "_store")->where('id', $article->id)->update([
                'quantite' => $newQty,
            ]);
            DB::update("UPDATE approvisionnement_" . $store . "_details set status_approv=1 where code_appr='" . $code . "' AND status_approv=0");
            DB::update("UPDATE approvisionnements_" . $store . "_store set global_status=1 where approv_code='" . $code . "'");
            DB::table("flow_stock_" . $store . "_movement")->insert([
                'ref_article' => $detail->codebar_article,
                'qty_flow' => $detail->qty_article,
                'unite_price_movement' => $detail->price_article,
                'total_price_movement' => doubleval($detail->price_article) * doubleval($detail->qty_article),
                'created_by' => Auth::user()->id,
                'movement_type' => 'MV_supplies',
            ]);
        }
        return Response::json(['result' => 'ok']);
    }

    public function generateCodeApprov()
    {
        $store = getStoreId();
        $much = DB::select("select approv_code as number from approvisionnements_" . $store . "_store");
        if (empty($much)) {
            $out = 1;
        } else {
            $out = intval(preg_replace("/[^0-9]/", '', $much[array_key_last($much)]->number)) + 1;
        }
        return "APP" . str_pad($out, 6, 0, STR_PAD_LEFT);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
