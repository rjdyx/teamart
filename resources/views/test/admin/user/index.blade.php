@extends('layouts.newapp')

@section('content')
            <div class="panel panel-default">
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @endif
                    <form method="POST" action="{{ url('admin/user/'.$user->id) }}" enctype="multipart/form-data">
                         {!! csrf_field() !!}
                        <input type="hidden" name="id" value="{{$user->id}}">
                        <div>
                            <div>
                                <label>注册邮箱</label>
                            </div>
                            <div>
                                <input type="text" name="email" value="{{$user->email}}" disabled="true">
                            </div>
                        </div>
                        <div>
                            <div>
                                <label>昵称</label>
                            </div>
                            <div>
                                <input type="text" name="name" value="{{$user->name}}" required="true">
                            </div>
                        </div>
                        <div>
                            <label>头像</label>
                            <div style="height: 100px;width:100px">
                                <img @if($user->avatar != null) src='{{ App\User::AVATAR.$user->avatar }}' @else src='/../baseImage/avatar/default.jpg' @endif style="height: 100px;width:100px">
                            </div>
                            <input type="file" name="avatar" id="avatar" accept="image/gif, image/jpeg,image/jpg, image/png">
                        </div>
                        <div>
                            <input type="submit" name="submit" value="保存">
                        </div>
                    </form>
                </div>
            </div>
@endsection