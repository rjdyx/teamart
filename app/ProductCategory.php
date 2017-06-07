<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{

    use SoftDeletes;
    protected $dates = ['deleted_at']; //开启deleted_at
    protected $table = 'product_category';

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
