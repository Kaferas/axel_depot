<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventaireModel extends Model
{
    use HasFactory;
    protected $table = "inventaires";
    protected $fillable = [
        'title_inventory',
        'description_inventory',
        'created_by',
        'status_inventaire',
        'reason_delete',
        'modified_by',
        'modified_at',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function inventaires_details(){
     //   return $this->hasMany(In);
    }
}
