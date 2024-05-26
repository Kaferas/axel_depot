<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlowStockMovement extends Model
{
    use HasFactory;
    protected $table = "flow_stock_movement";
    protected $fillable = [
        'ref_article',
        'qty_flow',
        'unite_price_movement',
        'total_price_movement',
        'created_by',
        'modified_at',
        'movement_type',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}
