<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//分销商佣金结账记录类
class Brokerage extends Model
{

    use SoftDeletes;
    protected $dates = ['deleted_at']; //开启deleted_at
    protected $table = 'brokerage';

}
