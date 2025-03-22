<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    protected $table = 'inventory';
    protected $fillable = ['product_id', 'cantidad', 'operacion'];
}
