@extends('layouts.newapp')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Panel title</h3>
    </div>
    <div class="panel panel-default">

        <div class="panel-body">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>id</th>
                    <th>用户名</th>
                    <th>类型</th>
                    <th>锁定</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <th></th>
                            <th>{{$user->id}}</th>
                            <th>{{$user->name}}</th>
                            <th>{{App\user::TYPE[$user->type]}}</th>
                            <th>{{$user->isLock==0?"否":"是"}}</th>
                            <th>
                            <a href={{url('/admin/users/'.$user->id.'/edit')}}>编辑</a>   
                            <form action={{url('admin/users/'.$user->id.'')}} method="POST">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type ="submit">
                                    删除
                                </button>
                            </form>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-center">
            {{ $users->links() }}
        </div>
    </div>
    </div>
@endsection