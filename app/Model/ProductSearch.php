<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductSearch extends Model
{
    protected $table    = 'product_search';
    public $timestamps  = true;
    public $primaryKey  = 'product_search_id';
}
