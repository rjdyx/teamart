<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    //
    public $table='feedbacks';
    public $timestamps = false;

	public function feedbackImage(){

	    return $this->hasOne('\App\FeedbackImage');
	}
}
