<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;

class DistributorController extends Controller
{
    //
    public function index(Request $request)
    {

        $users = User::where('type',1)->paginate(15);
        if($request->input('order')){
             if($request->input('order')=='asc'){
                 $users = User::where('type',1)->orderBy('name','asc')->paginate(15);
             }
            if($request->input('order')=='desc'){
                $users = User::where('type',1)->orderBy('name','desc')->paginate(15);
            }
        }

        //$users = DB::table('users')->paginate(15);//不支持自动屏蔽软删除的纪录
        return view(config('app.theme').'.admin.distributor.index')->with('users', $users);
    }
    public function edit($id)
    {
        //
        $user = User::find($id);
        if($user==null) return view("error");
        return view(config('app.theme').'.admin.distributor.edit')->with('user',$user);
    }

    public function show(Request $request){
        $this->validate($request, [
           'string'=> 'required',
        ]);
        $users =User::where('name','like','%'.$request->input('string').'%')->get();
        return view(config('app.theme').'.admin.distributor.show')->with('users',$users);
    }
    public function create(){
        $users = User::paginate(15);
        //$users = DB::table('users')->paginate(15);//不支持自动屏蔽软删除的纪录
        return view(config('app.theme').'.admin.distributor.add')->with('users', $users);
    }

    public function add(Request $request){
        $ids = $request->input('isDistributor');

        foreach($ids as $id){
            User::where('id',$id)->update(['type'=>1]);
        }
        $users = User::paginate(15);
        //$users = DB::table('users')->paginate(15);//不支持自动屏蔽软删除的纪录
        return view(config('app.theme').'.admin.distributor.index')->with('users', $users);


    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'isLock' => 'in:0,1',
            'proportion'=>'required',
        ]);
        $user =User::find($id);
        if($request->input('proportion')<1&&$request->input('proportion')>0){
            $user->proportion = $request->input('proportion');
            $user->type = $request->input('isDistributor');
            $user->save();
            $users = User::paginate(15);
            //$users = DB::table('users')->paginate(15);//不支持自动屏蔽软删除的纪录
            return view(config('app.theme').'.admin.distributor.index')->with('users', $users);
        }
        else{
            return view('error');
        }
    }
}
