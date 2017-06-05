<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Feedback;

class FeedbackController extends Controller
{
    //
    public function index()
    {
    	$feedbacks = Feedback::paginate(5);


    	return view(config('app.theme').'.admin.feedback.index')->with('feedbacks',$feedbacks);
    }

}
