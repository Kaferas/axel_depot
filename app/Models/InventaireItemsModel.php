<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventaireItemsModel extends Model
{
    use HasFactory;
    protected $table = "inventaires_details";

    protected $fillable = [
        'code_inventaire',
        'codebar_article',
        'name_article_inventaire',
        'qty_theorique_inventaire',
        'qty_physique_inventaire',
        'price_inventaire',
        'price_article',
        'difference_inventaire',
        'reason_delete',
        'status_inventaire',
        'created_by',
        'modified_by',
        'modified_at',
    ];
}
