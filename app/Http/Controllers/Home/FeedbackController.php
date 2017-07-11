<?php

namespace App\Http\Controllers\Home;

use App\Feedback;
use App\FeedbackImage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Array_;
use Illuminate\Support\Facades\Auth;
use IQuery;

class FeedbackController extends Controller
{
    //
    public function index(){
        $title = '意见反馈';
        return view(config('app.theme').'.home.feedback')->with('title', $title);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'contact' => 'required|max:50',
            'content' => 'required|max:2000',
        ]);
        $model = new Feedback;
        $model->contact = $request->contact;
        $model->content = $request->content;
        $model->date = date('Y-m-d H:i:s');
        $model->user_id = Auth::user()->id;

        $img = null;
        $imgs = array();
        //资源、上传图片名称、是否生成缩略图
        $pics = IQuery::uploads($request, 'imgs', true);
        if ($pics != 'false') {
            foreach ($pics as $pic) {
                $imgs[] = $pic['pic'];
            }
            $img = implode(',', $imgs);
            $model->img = $img;
        }

        if ($model->save()) return 1;
        return 0;
    }

}