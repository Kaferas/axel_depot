<?php

namespace App\Http\Controllers;

use App\Models\ValidationNotification;
use Carbon\Carbon;
use App\Models\Article;
use App\Models\Articles;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\InventaireModel;
use App\Models\FlowStockMovement;
use Illuminate\Support\Facades\DB;
use App\Models\InventaireItemsModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use PhpParser\Node\Stmt\TryCatch;

use function App\Helpers\getStoreId;
use function App\Helpers\getStores;

class InventaireController extends Controller
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
        $search = $request->query("searchKey");
        if ($from && $to && empty($search)) {
            $inventaires = DB::table('inventaires_' . $store . '_store as inv')->join("users", "users.id", "inv.created_by")->whereBetween('created_at', [$from, $to])->select("inv.*", "users.name")->get();
        } else if ($search && empty($from) && empty($to)) {
            $inventaires = DB::table('inventaires_' . $store . '_store as inv')->join("users", "users.id", "inv.created_by")->where('title_inventory', 'like', "%{$search}%")->orWhere('inventory_code', 'like', "%{$search}%")->orWhere('description_inventory', 'like', "%{$search}%")->select("inv.*", "users.name")->get();
        } else if ($from && $to && $search) {
            $inventaires = DB::table('inventaires_' . $store . '_store as inv')->join("users", "users.id", "inv.created_by")->whereBetween('created_at', [$from, $to])->where('title_inventory', 'like', "%{$search}%")->orWhere('inventory_code', 'like', "%{$search}%")->orWhere('description_inventory', 'like', "%{$search}%")->select("inv.*", "users.name")->get();
        } else {
            $inventaires = DB::table('inventaires_' . $store . '_store as inv')->join("users", "users.id", "inv.created_by")->orderBy('id', 'desc')->where('status_inventaire', 0)->select("inv.*", "users.name")->paginate(10);
        }
        return view("/inventaires/index", [
            'inventaires' => $inventaires,
            'from_date' => $request->query("from_date"),
            'to_date' => $request->query("to_date"),
            'search' => $search,
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
        $articles = DB::table('articles_' . $store . '_store as ar')->Join('categories', "categories.id", "ar.categorie_id")->where('status_article', 0)->select("ar.*", "categories.nom_categorie", "categories.color_categorie")->get();
        // dd($articles);
        return view("/inventaires/create", [
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
        try {
            //code...
            DB::beginTransaction();
            $title = $_POST['title_approv'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $qtyPh = $_POST['qtyPh'];
            $qtyTh = $_POST['qtyTh'];
            $codebar = $_POST['codebar'];
            $nameArt = $_POST['nameArt'];
            $current_code = $this->generateInventaireCode();
            $user = Auth::user()->id;
            DB::table('inventaires_' . $store . '_store')->insertGetId(
                array('inventory_code' => $current_code, 'title_inventory' => $title, 'description_inventory' => $description, 'created_by' => $user,  'created_at' => date('d-m-y h:i:s'))
            );
            for ($i = 0; $i < count($codebar); $i++) {
                $out[] = [
                    'code_inventaire' => $current_code,
                    'codebar_article' => $codebar[$i],
                    'name_article_inventaire' => $nameArt[$i],
                    'qty_theorique_inventaire' => $qtyTh[$i],
                    'price_inventaire' => $price[$i] * $qtyPh[$i],
                    'qty_physique_inventaire' => $qtyPh[$i],
                    'difference_inventaire' => intval($qtyTh[$i]) - intval($qtyPh[$i]),
                    'created_by' => $user,
                    'price_article' => $price[$i],
                ];
            }
            $approv_det = DB::table("inventaires_" . $store . "_details")->insert($out);
            // ValidationNotification::create([
            //     'user_id' => Auth::user()->id,
            //     'validate_by' =>  Auth::user()->id,
            //     'created_by' => 0,
            //     'is_opened_by' => 'NO',
            //     'code' => $current_code,
            //     'item_id' => $inventaire->id,
            //     'type' => 'INVENTAIRE',
            //     'status' => 'PENDING',
            // ]);
            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            dd($th->getMessage());
        }

        if ($approv_det) {
            return Response::json(['result' => 'ok']);
        } else {
            return Response::json(['error' => 'ok']);
        }
    }

    public function generateInventaireCode()
    {
        $store = getStoreId();
        $much = DB::select("select inventory_code as number from inventaires_" . $store . "_store");
        if (empty($much)) {
            $out = 1;
        } else {
            $out = intval(preg_replace("/[^0-9]/", '', $much[array_key_last($much)]->number)) + 1;
        }
        return "INV" . str_pad($out, 6, 0, STR_PAD_LEFT);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($inventaire)
    {
        $store = getStoreId();
        $inventaire = DB::table("inventaires_" . $store . "_store")->where('id', $inventaire)->get()->first();
        $inventaire_details = DB::select("SELECT det.*,us.name FROM inventaires_" . $store . "_details det join users us ON us.id=det.created_by where code_inventaire='" . $inventaire->inventory_code . "' ");
        return view("/inventaires/view", [
            'inventaire' => $inventaire,
            'details' => $inventaire_details
        ]);
    }
    // public function display_notification($notification_id)
    // {
    //     //  dd($inventaire);

    //     $v = ValidationNotification::find($notification_id);
    //     // Check type of Notification
    //     if ($v->status != 'OPENED' && $v->type != 'ARTICLE NOTIFICATION') {
    //         $v->status = 'OPENED';
    //         $v->is_opened_by = auth()->user()->id;
    //         $v->save();
    //     }
    //     // Display stories
    //     if ($v->type == 'SORTIE' || $v->type == 'CONFIRMATION SORTIE') {
    //         return  redirect()->route('sorties.show', $v->item_id);
    //     }
    //     if ($v->type == 'INVENTAIRE') {
    //         return  redirect()->route('inventaires.show', $v->item_id);
    //     }
    //     if ($v->type == 'ARTICLE NOTIFICATION') {
    //         // affichades des produits en desous de suil

    //         return  redirect()->route('articles.index');
    //     }
    // }

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


    public function confirmerInventaire($code)
    {
        $store = getStoreId();
        try {
            //code...
            DB::beginTransaction();
            $current_detail = DB::select("SELECT price_article,codebar_article,qty_physique_inventaire FROM inventaires_" . $store . "_details where code_inventaire='" . $code . "' AND status_inventaire=0");
            foreach ($current_detail as $detail) {
                $article = DB::table("articles_" . $store . "_store")->where("codebar_article", $detail->codebar_article)->first();
                $newQty = $detail->qty_physique_inventaire;
                DB::table("articles_" . $store . "_store")->where('codebar_article', $detail->codebar_article)->update([
                    'quantite' => $newQty,
                ]);
                DB::update("UPDATE inventaires_" . $store . "_details set status_inventaire=1 where code_inventaire='" . $code . "' AND status_inventaire=0");

                DB::update("UPDATE inventaires_" . $store . "_store set global_status=1 where inventory_code='" . $code . "'");

                DB::table("flow_stock_" . $store . "_movement")->insert([
                    'ref_article' => $detail->codebar_article,
                    'qty_flow' => $detail->qty_physique_inventaire,
                    'unite_price_movement' => $detail->price_article,
                    'total_price_movement' => doubleval($detail->price_article * $detail->qty_physique_inventaire),
                    'created_by' => Auth::user()->id,
                    'movement_type' => 'MV_invetory',
                ]);
            }
            $inventory_id = DB::table('inventaires_' . $store . '_store')->where('inventory_code', $code)->first()->id;


            // ValidationNotification::create([
            //     'user_id' => Auth::user()->id,
            //     'validate_by' =>  Auth::user()->id,
            //     'created_by' => 0,
            //     'is_opened_by' => 'NO',
            //     'code' => $code,
            //     'item_id' =>  $inventory_id,
            //     'type' => 'INVENTAIRE',
            //     'status' => 'PENDING',
            // ]);

            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            dd($th->getMessage());
        }

        return Response::json(['result' => 'ok']);
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
     *c
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
