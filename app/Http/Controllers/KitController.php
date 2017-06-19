<?php 
namespace App\Http\Controllers;
/*
 * @version 生成验证码
 * @author:李明村 
 * @data：2016/9/27
 * @description 生成验证码
 */

//生成验证码控制器
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//引用对应的命名空间
// use Gregwar\Captcha\PhraseBuilder;
use Gregwar\Captcha\CaptchaBuilder;
use Session;

class KitController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function captcha(Request $request)
    {
        //生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder;
        $builder->setMaxAngle($maxAngle=1);
        $builder->setMaxOffset($maxOffset=1);
        $builder->setPhrase($phrase = rand('1000','9999'));
        //可以设置图片宽高及字体
        $builder->build($width = 200, $height = 80, $font = null);
        //把内容存入session
        $url = $builder->inline();  //获取图形验证码的url
        $request->session()->put('milkcaptcha', $builder->getPhrase());  //将图形验证码的值写入到session中
        return response()->json($url);
    }
}