<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depot extends Model
{
    use HasFactory;

    protected $guarded;

    public function user()
    {
        return $this->belongsTo(User::class, 'gerant_id');
    }

    public static function stores()
    {
        $stores = Depot::where('deleted_status', 0)->orderBy('id', "DESC")->get();
        return $stores;
    }

    public static function getStoreName($id)
    {
        $name =  Depot::find($id)->nom_depot;
        return $name;
    }
}