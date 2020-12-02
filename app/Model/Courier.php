<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
	protected $table    = 'delivery_types';
    public $timestamps  = false;
    public $primaryKey  = 'id';

    public function scopedata($query)
    {
    	return $query->where('active', 1);
    }
}
