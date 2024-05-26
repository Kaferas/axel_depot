<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use App\Http\Requests\StoreArticlesRequest;
use App\Http\Requests\UpdateArticlesRequest;
use App\Models\Categories;
use Illuminate\Support\Facades\DB;

use function App\Helpers\allowedStore;
use function App\Helpers\getStoreId;

class ArticlesController extends Controller
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
            ->orderBy('id', 'desc')
            ->get();
        return view("articles.index", ['articles' => $articles,]);
    }

    public function generateCodeBar($length = 10)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $current_code = $this->generateCodeBar(8);
        $categories = Categories::where("deleted_status", 0)->get();
        return view("articles.add", ['categories' => $categories, 'code' => $current_code]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticlesRequest $request)
    {
        $store = session('currentStore') ?? allowedStore()[0];
        $article_name = $request->get("article_name");
        $categorie_id = $request->get("categorie_id");
        $price_achat = $request->get("price_achat");
        $price_vente = $request->get("price_vente");
        $unite_mesure = $request->get("unite_mesure");
        $codebar_article = $request->get("codebar_article");
        DB::insert('insert into articles_' . $store . '_store (article_name, categorie_id,price_achat,price_vente,unite_mesure,codebar_article) values (?,?,?,?,?,?)', [$article_name, $categorie_id, $price_achat, $price_vente, $unite_mesure, $codebar_article]);
        return redirect("/articles")->with('success', "Article cree avec Success");
    }

    /**
     * Display the specified resource.
     */
    public function show(Articles $articles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($article)
    {
        $store = session('currentStore') ?? allowedStore()[0];
        $article = DB::table("articles_" . $store . "_store")->where('id', $article)->get()->first();
        $categories = Categories::where("deleted_status", 0)->get();
        return view("articles.edit", ['article' => $article, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreArticlesRequest $request, $article)
    {
        $article_name = $request->get("article_name");
        $categorie_id = $request->get("categorie_id");
        $price_achat = $request->get("price_achat");
        $price_vente = $request->get("price_vente");
        $unite_mesure = $request->get("unite_mesure");
        $codebar_article = $request->get("codebar_article");
        $store = session('currentStore') ?? allowedStore()[0];
        DB::table("articles_" . $store . "_store")
            ->where('id', $article)
            ->update(['article_name' => $article_name, 'categorie_id' => $categorie_id, 'price_achat' => $price_achat, 'price_vente' => $price_vente, 'unite_mesure' => $unite_mesure, 'codebar_article' => $codebar_article]);
        return redirect("/articles")->with('update', "Article modifie avec Success");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($article)
    {
        $store = session('currentStore') ?? allowedStore()[0];
        DB::table("articles_" . $store . "_store")
            ->where('id', $article)
            ->update(['deleted_status' => 1]);
        return redirect("/articles")->with('delete', "Article Supprime avec Success");
    }
}