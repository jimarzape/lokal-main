<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ItemRating extends Model
{
    protected $table    = 'item_rating';
    public $timestamps  = true;
    public $primaryKey  = 'rating_id';


    public function scopegeneric($query, $product_id)
    {
    	return $query->leftjoin('users','users.userId','user_id')
    			     ->where('product_id', $product_id);
    }

}
