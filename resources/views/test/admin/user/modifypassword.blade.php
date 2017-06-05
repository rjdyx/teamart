@extends('layouts.newapp')

@section('content')
            <div class="panel panel-default">
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @endif
                    <form method="POST" action="{{ url('admin/user/modifypassword/'.$user->id) }}" enctype="multipart/form-data">
                         {!! csrf_field() !!}
                        <input type="hidden" name="id" value="{{$user->id}}">
                        <div>
                            <div><label>原密码</label></div>
                            <div><input type="password" name="password" required="true"></div>
                        </div>
                        <div>
                            <div><label>新密码</label></div>
                            <div><input type="password" name="newpassword" required="true"></div>
                        </div>
                        <div>
                            <div><label>确认密码</label></div>
                            <div><input type="password" name="newpassword1" required="true"></div>
                        </div>
                        <div>
                            <input type="submit" name="submit" value="保存">
                        </div>
                    </form>
                </div>
            </div>
@endsection