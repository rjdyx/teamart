<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImg extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at']; //开启deleted_at
    protected $table = 'product_img';

    public function product()
    {
    	return $this->belongsTo('App\Product');
    }
}
