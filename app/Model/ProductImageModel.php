<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductImageModel extends Model
{
    protected $table    = 'product_images';
    public $timestamps  = true;
    public $primaryKey  = 'product_image_id';
}
