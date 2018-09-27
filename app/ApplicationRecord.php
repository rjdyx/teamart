<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationRecord extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'application_record';
}
