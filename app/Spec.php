<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spec extends Model
{

    use SoftDeletes;
    protected $dates = ['deleted_at']; //¿ªÆôdeleted_at
    protected $table = 'spec';

}
