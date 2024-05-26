<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovisionnementDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'code_appr',
        'codebar_article',
        'qty_article',
        'price_article',
        'total_article',
        'status_approv',
        'reason_delete',
        'created_by',
        'modified_by',
        'modified_at',
    ];
}
