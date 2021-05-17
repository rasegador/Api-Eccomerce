<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product';

    protected $fillable = [
        'id',
        'name',
        'quantity',
        'value'
    ];

    protected $hidden = [
        'deleted_at',
        'updated_at'
    ];

}
