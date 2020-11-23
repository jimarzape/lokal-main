<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BrandModel extends Model
{
    protected $table    = 'brands';
    public $timestamps  = false;
    public $primaryKey  = 'brand_id';

    public function scopegeneric($query)
    {
    	return $query->where('brand_archived', 0);
    }
}
