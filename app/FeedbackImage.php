<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedbackImage extends Model
{
    //
    const FEEDBACK = '/../upload/feedback/';
    public $table='feedback_images';
    public $timestamps = false;
    public function Feedback(){

        return $this->belongsTo('\App\Feedback');
    }
}
