<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approvisionnement extends Model
{
    use HasFactory;
    protected $fillable = [
        'approv_code',
        'approv_amount',
        'approv_fournisseur',
        'created_by',
        'modified_by',
        'modified_at',
    ];
    public function fournisseur()
    {
        return $this->hasOne(Fournisseur::class, 'id', 'approv_fournisseur');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function approv_details()
    {
        return $this->hasOne(ApprovisionnementDetails::class, 'approv_code', 'code_appr');
    }
}
