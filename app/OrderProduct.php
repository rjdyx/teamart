<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at']; //开启deleted_at
    public $table='order_product';
    // public $timestamps = false;
}
