<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'order_product';

    protected $fillable = [
        'id',
        'quantity',
        'order_id',
        'product_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function order(){
        return $this->belongsTo(Order::class, 'id', 'order_id');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

}
