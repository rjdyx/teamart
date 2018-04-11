<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cheap extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at']; //开启deleted_at
    protected $table = 'cheap';
    const CHEAP_CLOSE = 0;
    const CHEAP_OPEN = 1;
    const STATE =[
    	self::CHEAP_CLOSE => '关闭',
    	self::CHEAP_OPEN =>'打开',
    ];
}
