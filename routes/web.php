<?php

use App\Http\Controllers\ApprovisionnementController;
use App\Http\Controllers\ApprovisionnementDetails;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DepotController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\InventaireController;
use App\Http\Controllers\InventaireItem;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::resource("/depots", DepotController::class);
    Route::resource("/fournisseurs", FournisseurController::class);
    Route::resource("/clients", ClientController::class);
    Route::resource("/articles", ArticlesController::class);
    Route::resource("/categories", CategoriesController::class);
    Route::resource("/users", UserController::class);
    Route::resource("/sells", SellController::class);
    // Route::post("/commandeCode", [SellController::cl ass, "generateCommandeNumber"])->name('generateCommandeNumber');
    Route::post("paidReste", [InvoiceController::class, "paidReste"])->name('paidReste');
    Route::resource("/invoices", InvoiceController::class);
    Route::get("/invoices.paid/{commande}", [InvoiceController::class, "paid"])->name("paid");
    Route::post('changeworkingYear', [UserController::class, "changeworkingYear"])->name("changeworkingYear");
    Route::resource("details", ApprovisionnementDetails::class);
    Route::post("confirm_approv/{code}", [ApprovisionnementController::class, 'confirmerApprov'])->name("confirmer_approvisionnement");
    Route::resource("approvisionnements", ApprovisionnementController::class);
    Route::post("confirm_approv/{code}", [ApprovisionnementController::class, 'confirmerApprov'])->name("confirmer_approvisionnement");
    Route::post("getDePot", [UserController::class, 'getDePot'])->name("getDePot");
    Route::resource("inventaires", InventaireController::class);
    Route::post("confirm_inventaire/{code}", [InventaireController::class, 'confirmerInventaire'])->name("confirmer_inventaire");
    Route::resource("inventaires_details", InventaireItem::class);
    Route::get('display_notification/{notification_id}', [InventaireController::class, 'display_notification'])->name('display_notification');
});

// Route::middleware(['auth', 'can:is_fournisseur_group'])->group(function () {
// });


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';