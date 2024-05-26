<?php

namespace App\Http\Controllers;

use App\Models\Depot;
use App\Http\Requests\StoreDepotRequest;
use App\Http\Requests\UpdateDepotRequest;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class DepotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $depots = Depot::with('user')->get();
        return view("depots.index", ['depots' => $depots]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::whereNull("depot")->get();
        return view("depots.add", ['gerants' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepotRequest $request)
    {
        $depot = Depot::create($request->validated());
        Depot::where("id", $depot->id)->update(['has_gerant' => 1]);
        Schema::create("articles_" . $depot->id . "_store", function (Blueprint $table) {
            $table->id();
            $table->string('codebar_article');
            $table->string('article_name');
            $table->integer('categorie_id');
            $table->double('price_achat');
            $table->double('price_vente');
            $table->string('unite_mesure');
            $table->double('quantite')->default(0);
            $table->integer('deleted_status')->default(0);
            $table->timestamps();
        });
        Schema::create("approvisionnements_" . $depot->id . "_store", function (Blueprint $table) {
            $table->id();
            $table->string("approv_title");
            $table->string("approv_code");
            $table->double("approv_amount", 15, 2)->nullable();
            $table->integer("approv_fournisseur");
            $table->integer("global_status")->default(0);
            $table->integer("created_by");
            $table->integer("modified_by")->nullable();
            $table->timestamp("modified_at")->nullable();
            $table->timestamps();
        });
        Schema::create("approvisionnement_" . $depot->id . "_details", function (Blueprint $table) {
            $table->id();
            $table->string('code_appr');
            $table->string('codebar_article');
            $table->string('qty_article');
            $table->string('price_article');
            $table->string('total_article');
            $table->string('name_article');
            $table->string('reason_delete')->nullable();
            $table->string('status_approv')->default(0)->comment("0: En attente,1: approuved,2: Rejeter");
            $table->integer("created_by");
            $table->integer("modified_by")->nullable();
            $table->timestamp("modified_at")->nullable();
            $table->timestamps();
        });
        Schema::create("Inventaires_" . $depot->id . "_store", function (Blueprint $table) {
            $table->id();
            $table->string('title_inventory');
            $table->string('description_inventory');
            $table->string('inventory_code');
            $table->integer("created_by");
            $table->integer("global_status")->default(0);
            $table->string('status_inventaire')->default(0)->comment("0: En attente,1: approuved,2: Rejeter");
            $table->string('reason_delete')->nullable();
            $table->integer("modified_by")->nullable();
            $table->timestamp("modified_at")->nullable();
            $table->timestamps();
        });
        Schema::create("inventaires_" . $depot->id . "_details", function (Blueprint $table) {
            $table->id();
            $table->string('code_inventaire');
            $table->string('codebar_article');
            $table->string('name_article_inventaire');
            $table->integer('qty_theorique_inventaire');
            $table->integer('qty_physique_inventaire');
            $table->integer('price_inventaire');
            $table->integer('price_article');
            $table->integer('difference_inventaire');
            $table->string('reason_delete')->nullable();
            $table->string('status_inventaire')->default(0)->comment("0: En attente,1: approuved,2: Rejeter");
            $table->integer("created_by");
            $table->integer("modified_by")->nullable();
            $table->timestamp("modified_at")->nullable();
            $table->timestamps();
        });
        Schema::create("flow_stock_" . $depot->id . "_movement", function (Blueprint $table) {
            $table->id();
            $table->text('ref_article');
            $table->integer('qty_flow');
            $table->integer('unite_price_movement');
            $table->integer('total_price_movement');
            $table->integer('created_by');
            $table->timestamp("modified_at")->nullable();
            $table->string('movement_type')->comment("MV_invetory: Inventaire, MV_supplies: Approvisionnemnet, MV_out: Sorties, MV_back: Retour");
            $table->timestamps();
        });
        Artisan::call("migrate");
        return redirect("/depots")->with('success', 'Depot bien Cree');
    }

    /**
     * Display the specified resource.
     */
    public function show(Depot $depot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Depot $depot)
    {
        //
        $users = User::all();
        return view("depots.edit", ['depot' => $depot, 'gerants' => $users]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreDepotRequest $request, Depot $depot)
    {
        $depot->update($request->validated());
        return redirect("/depots")->with('update', 'Depot mise a jour');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Depot $depot)
    {
        //
    }
}
