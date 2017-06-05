<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    //
    use SoftDeletes;
    protected $table = 'product_categories';

    public function children()
    {
    	return $this->hasMany('App\ProductCategory','parent_id');
    }

    public function parent()
    {
    	return $this->belongsTo('App\ProductCategory');
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
