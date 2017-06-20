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
use App\Http\Model\Log;
use App\Http\Model\Company;
use ReflectionClass;

class IQuery{

    //加入排序 (参数1：数据对象; 参数2：传递数据对象; 参数3：排序字段数组)
    public function ofOrder(&$query, $request, $order_params)
    {
        $sort = $request->input('_sort');
        $order = $request->input('_order');
        if($sort != null && $sort != ''){
            if($order != null && $order == 'desc') $query = $query->orderBy($order_params[$sort], 'desc');
            else $query = $query->orderBy($order_params[$sort],'asc');
        }else{
            $query = $query->orderBy($order_params['id'], 'desc');
        }
        return $query;
    }

    //加入模糊查询 (参数1：数据对象; 参数2：接收的条件文本字符串; 参数3：模糊查询字段数组)
    public function ofText(&$query, $val, $text_params=['name'])
    {
        $texts=  explode(' ',$val);
        $query = $query->where(function ($query) use ($text_params, $texts){
            foreach($text_params as $param){
                $query->orWhere(function($query) use ($param, $texts){
                    foreach($texts as $text){
                        $query->where($param,'like', '%'.$text.'%');
                    }
                });
            }
        });
        return $query;
    }
    
    //加入平台where条件查询
    public function ofWhere(&$query, $request, $text_params=['name'], $other_params='') {
        $query = $query;
    }

    //加入查询组合查询(下拉框，文本)
    public function ofSearch(&$query, $request, $text_params=['name'], $other_params='') {
        if($other_params!='') {
            $params_date = $other_params['date'];
        } else {
            $params_date = '';
        }
        $params=$request->params;    //获取数组对象
        if($params!='{}' && $params!='') {
            $params=$this->changeType($params);
            $query = $query->where(function($query) use ($params,$text_params,$request,$params_date) {
                foreach($params as $key=>$param) {
                    // 文本查询
                    if($key=="query_text") {
                        if($param!='') {
                            $this->ofText($query,$param,$text_params);
                        }
                    }
                    // 分页
                    else if($key=="page") {
                        $request->merge(['page'=>$params['page']]);
                    }
                    else if($key=="beforeDate") {
                        if($param!='') {
                            $query->where($params_date,'>=',$param);
                        }
                    }
                    else if($key=="afterDate") {
                        if($param!='') {
                            $query->where($params_date,'<=',$param);
                        }
                    }
                    else {
                        if($param!='') {
                            $query->where($key,$param);
                        }
                    }
                }
            });
        }
        return $query;
    }
    
    //图片异步上传
    public function upload($request, $file_pic='img', $minState=true)
    {
        $file = $request->file($file_pic);
        if ($request->hasFile($file_pic)) {
            $path = config('app.image_path').'/upload/';
            $Extension = $file->getClientOriginalExtension();
            $filename = 'FX_'.time().rand(1,9999).'.'. $Extension;
            $check = $file->move($path, $filename);
            $filePath = $path.$filename; //原图路径加名称
            $pics = array();
            $pics['pic']= $filePath;//原图

            if($minState) {
                $newfilePath = $path.'FX_S_'.time().rand(1,9999).'.'. $Extension;//缩略图路径名称
                $this->img_create_small($filePath,config('app.thumb_width'),config('app.thumb_height'),$newfilePath);  //生成缩略图
                $pics['thumb']= $newfilePath;//缩略图
            }
            return $pics;//返回原图 缩略图 的路径 数组
        }else{
            return 'false';
        }
    }

    //组图片异步上传
    public function uploads($request, $pics='imgs', $minState=true)
    {            
        $pics = array();
        $path = config('app.image_path').'/upload/';
        $files = $request->file($pics);
        if (!empty($files)) {
            foreach ($files as $k => $file) {
                $Extension = $file->getClientOriginalExtension();
                $filename = 'FX_'.time().rand(1,9999).'.'. $Extension;
                $check = $file->move($path, $filename);
                $filePath = $path.$filename; //原图路径加名称
                $pics[$k]['pic']= $filePath;//原图
                if($minState) {
                    $newfilePath = $path.'FX_S_'.time().rand(1,9999).'.'. $Extension;//缩略图路径名称
                    $this->img_create_small($filePath,config('app.thumb_width'),config('app.thumb_height'),$newfilePath);  //生成缩略图
                    $pics[$k]['pic_thumb']= $newfilePath;//缩略图
                }
            }
        }
        return 'false';
    }
    //生成缩略图
    function img_create_small($big_img, $width, $height, $small_img) {  //原始大图地址，缩略图宽度，高度，缩略图地址
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
    
    //获取批次号
    public function getSerial($table,$pre) {
        $pre_serial = DB::table($table)
                    ->where($table.'.company_id','=',Auth::user()->company_id) 
                    ->orderBy($table.'.id','desc')
                    ->select($table.'.serial')
                    ->first();
        if($pre_serial!=null) {
            $af_number = intval(substr($pre_serial->serial,-4))+1;
            $lenth = strlen($af_number);
            $kw = '000';
            if ($lenth==2) {
              $kw = '00';
            }
            if ($lenth==3) {
              $kw = '0';
            }
            if ($lenth==4) {
              $kw = '';
            }
            $serial = $pre.date('Ymd').$kw.$af_number;
            if ($pre_serial=='' || $pre_serial==null) {
                $serial = $pre.date('Ymd').'0001';
            }
        }
        else {
            $serial = $pre.date('Ymd').'0001';
        }
        return $serial;
    }
    
    //加入日志
    public function ofLog($module,$operate,$content)
    {
        $log = new Log;
        $log->datetime = date('Y-m-d H:i:s');
        $log->module = $module;
        $log->operate = $operate;
        $log->content = $operate.'数据成功';
        //$log->ip = $_SERVER["REMOTE_ADDR"];
        if (isset(Auth::user()->company_id) && !empty(Auth::user()->company_id)){
            $log->company_id = Auth::user()->company_id;
        }
        if (isset(Auth::user()->id) && !empty(Auth::user()->id)){
            $log->user_id = Auth::user()->id;
        }
        $log->save();
    }

    //获取excel表
    public function getExcel($excel,$filename,$export) {
        ob_end_clean();//清除缓冲区,避免乱码
        $excel->create($filename, function($excel1) use($export) {
            $excel1->sheet('Excel sheet', function($sheet) use($export) {
                $sheet->fromArray($export);
                $sheet->setOrientation('landscape');
            });
        })->export('xls');
    }

    //获取excel文件
    public function getFile($request) {
        $file = $request->file('excel_file');
        $image_path = config('app.excel_path');   //文件根目录
        if ($request->hasFile('excel_file')) {
                $path = $image_path.'/excel/';
                $Extension = $file->getClientOriginalExtension();  //文件后缀
                $filename = time().'.'. $Extension;  //文件加密
                $file->move($path, $filename);
                $filePath = $path.$filename;
        }
        if($Extension!='xls'&&$Extension!='xlsx') {
            @unlink($filePath);
            return 'false';
        }
        return $filePath;
    }
    
    // 区分列表中的数据信息
    public function getDistince($curl,$routeId,$opqcurl) {
        $curl = $this->changeType($curl);
        $opqcurl = $this->changeType($opqcurl);
        $opqcurl = explode('/',$opqcurl['opqcurl']);   // 拆分字符串
        $set_id = $opqcurl[0].'_id';
        $id = $opqcurl[1];
        $get_id = $routeId['routeId'].'_id';
        if($get_id == 'come-rfid_id') {
            $get_id = 'rfid_id';
        }
        $model = studly_case(str_replace("-","_",ucfirst($curl['curl'])));
        $class = new ReflectionClass('App\Http\Model\\'.ucfirst($model));//建立这个类的反射类
        $model  = $class->newInstanceArgs();//相当于实例化类
        if ($set_id == 'come_id' || $set_id == '{x}_id') {
            $res = $model->select(''.$get_id)->get();
        } else {
            $res = $model->where($set_id,$id)->select(''.$get_id)->get();
        }
        $arr = [];
        foreach($res as $r) {
            $arr[] = $r->$get_id;
        }
        if ($set_id == 'dispose_id') {
            $rds =  \App\Http\Model\ComeRfid::select('rfid_id')->get();
            foreach($rds as $rd) {
                $arr[] = $rd->rfid_id;
            }
        }
        return $arr;
    }
    
    // 判断某表是否含有该字段
    public function setField($data, $table, $field) {
        $t = DB::table($table)->get();
        if (!$t->isEmpty()) {
            if(isset($t[0]->$field)) {
                $data = $data->where($field,'=',0);
                return $data;
            } else {
                return $data;
            }
        } else {
            return $data;
        }
    }

}