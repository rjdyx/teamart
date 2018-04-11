<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at']; //开启deleted_at

    const STATUS = [
        0 => '下架',
        1 => '上架',
    ];
    
    protected $table = 'product';

    public function category()
    {
    	return $this->belongsTo('App\ProductCategory');
    }

    public function images()
    {
    	return $this->hasMany('App\ProductImage');
    }

    public function types()
    {
    	return $this->hasMany('App\ProductType');
    }

}
