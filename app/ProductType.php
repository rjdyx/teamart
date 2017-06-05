<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductType extends Model
{
    //
    use SoftDeletes;
    protected $table = 'product_types';

    public function product()
    {
    	return $this->belongsTo('App\Product');
    }
}
