<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande_details extends Model
{
    use HasFactory;

    protected $table = "commandes_details";

    protected $guarded;
}