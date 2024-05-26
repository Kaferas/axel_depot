<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiements extends Model
{
    use HasFactory;

    protected $table = "paiements_factures";

    protected $guarded;


    public function clients()
    {
        return $this->hasOne(Client::class, "id", "client_id");
    }

    public function user()
    {
        return $this->hasOne(User::class, "id", "created_by");
    }
}
