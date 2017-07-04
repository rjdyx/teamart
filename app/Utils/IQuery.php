<?php

/*
 * @version: 0.1 查询工具类范例
 * @author: gsl
 * @date: 2017/06/08
 * @description:公共调用方法
 *
 */
namespace app\Utils;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Log;
use ReflectionClass;

class IQuery{

    //图片异步上传
    public function upload($request, $file_pic='img', $minState=true)
    {
        $file = $request->file($file_pic);
        if ($request->hasFile($file_pic)) {
            return $this->uploadOrs($file, $minState);
        }else{
            return 'false';
        }
    }

    //多图片异步上传
    public function uploads($request, $pics='imgs', $minState=true)
    {         
        $imgs = array();
        $files = $request->file($pics);
        if (!empty($files) && count($files) && is_array($files)) {
            foreach ($files as $k => $file) {
                $imgs[$k] = $this->uploadOrs($file, $minState);
            }
            return $imgs;
        }
        return 'false';
    }

    //单图上传方法
    public function uploadOrs($file, $minState)
    {
        $pics = array();
        $path = config('app.image_path');
        $Extension = $file->getClientOriginalExtension();
        $filename = 'FX_'.time().rand(1,9999).'.'. $Extension;
        $check = $file->move($path, $filename);
        $filePath = $path.$filename; //原图路径加名称
        $pics['pic']= $filePath;//原图

        if($minState) {
            $newfilePath = $path.'FX_S_'.time().rand(1,9999).'.'. $Extension;//缩略图路径名称
            $this->img_create_small($filePath,config('app.thumb_width'),config('app.thumb_height'),$newfilePath);  //生成缩略图
            $pics['thumb']= $newfilePath;//缩略图
        }
        return $pics;//返回原图 缩略图 的路径 数组
    }

    //生成缩略图
    public function img_create_small($big_img, $width, $height, $small_img) 
    {  
        //原始大图地址，缩略图宽度，高度，缩略图地址
        $imgage = getimagesize($big_img); //得到原始大图片
        switch ($imgage[2]) { // 图像类型判断
        case 1:
        $im = imagecreatefromgif($big_img);
        break;
        case 2:
        $im = imagecreatefromjpeg($big_img);
        break;
        case 3:
        $im = imagecreatefrompng($big_img);
        break;
        }
        $src_W = $imgage[0]; //获取大图片宽度
        $src_H = $imgage[1]; //获取大图片高度
        $tn = imagecreatetruecolor($width, $height); //创建缩略图
        imagecopyresampled($tn, $im, 0, 0, 0, 0, $width, $height, $src_W, $src_H); //复制图像并改变大小
        imagejpeg($tn, $small_img); //输出图像
    }
    
    //删除图片方法
    public function destroyPic($class,$id,$image='img') {
        $p = $class::where('id','=',$id)->first();
        if($image=='img') {
            if (empty($p->img) || empty($p->thumb)) return 'false';
            $img = str_replace("\\","/",public_path().'/'.$p->img);
            $thumb = str_replace("\\","/",public_path().'/'.$p->thumb);
            if (is_file($img)) unlink($img);
            if (is_file($thumb))  unlink($thumb); 
        }
        else {
            if (empty($p->$image)) return 'false';
            $img = str_replace("\\","/",public_path().'/'.$p->$image);
            if (is_file($img)) unlink($img); 
        }
        return 'true';
    }
    
    //加入日志
    public function ofLog($module, $operate)
    {
        $log = new Log;
        $log->table = $module;
        $log->operate = $operate;
        $log->ip = $_SERVER["REMOTE_ADDR"];
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)){
            $log->user_id = Auth::user()->id;
        }
        $log->save();
    }

    //生成订单号
    public function orderSerial()
    {
        $date = date('Ymd');
        $rand = rand(99999,999999);
        $per = 'Fx';
        return $per.$rand.$date;
    }
}