<?php

namespace App\Http\Controllers\Home;

use App\Feedback;
use App\FeedbackImage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Array_;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    //
    public function index(){
        return view(config('app.theme').'.home.feedback');
    }
    public function store(Request $request)
    {
        define("FILEPATH","localhost");
        $this->validate($request, [
            'fcontent' => 'required|max:255',
            'fphone' => 'required|min:8|max:11|regex:[^[0-9]]',
            'fname' => 'required'
        ]);
        $feedback = new \App\Feedback;
        $feedback->name = $request->fname;
        $feedback->content = $request->fcontent;
        $feedback->phone = $request->fphone;
        $file = $request->file('fphoto');
        $destinationPath = 'upload/feedback';
        $allowed_extensions = ['png', 'gif', 'jpg'];
        if(!$file){
            $fileName=0;
        }else {
            if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
                return ['error' => 'you only upload PNG,GIF,JPG photo'];
            }
            $extension = $file->getClientOriginalExtension();

            $fileName = str_random(10) . '.' . $extension;
            $file->move($destinationPath, $fileName);
            //$filepath = asset($destinationPath, $fileName);
        }

        if ($feedback->save()) {
            $feedback1 = new \App\Feedback;
            $feedback_rs = $feedback1::where('phone', $request->fphone)->get();
            foreach ($feedback_rs as $value) {
                $feedback_id = $value->id;

            }
            if($fileName) {
                $feedbackImage = new \App\FeedbackImage;
                $feedbackImage->path =  $fileName;
                $feedbackImage->feedback_id = $feedback_id;

                if ($feedbackImage->save()) {
                    return 'ok';
                } else {
                    return redirect()->back()->withInput()->withErrors('提交失败');
                }
            }else{
                return 'ok';
            }

        }

    }}