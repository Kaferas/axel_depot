<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    use HasFactory;

    protected $guarded;


    public function categories()
    {
        return $this->belongsTo(Categories::class, 'categorie_id');
    }
}
