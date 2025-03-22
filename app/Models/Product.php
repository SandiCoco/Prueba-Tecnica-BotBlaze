<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Product extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'descripcion', 'precio', 'cantidad'];

    public function updateStock($quantity, $type)
    {
        $this->cantidad = $type === 'entrada' ? $this->cantidad + $quantity : $this->cantidad - $quantity;
        $this->save();
    }

}
