<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $table = "commandes";

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
