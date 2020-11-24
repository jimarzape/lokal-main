<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductRate extends Model
{
    protected $table    = 'product_rate';
    public $timestamps  = true;
    public $primaryKey  = 'rate_id';
}
