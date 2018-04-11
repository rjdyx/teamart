@extends('layouts.app')

@section('content')
    <div class="container">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">意见反馈</div>

                    <div class="panel-body">

                        <form action="{{url('/feedback')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                         <table >
                             <tr><td>姓名：</td><td><input type="text" name="fname" ></td></tr>

                             <tr><td>联系方式：</td><td><input name="fphone" type="text"  ></td></tr>

                             <tr><td>反馈内容：</td><td><textarea name="fcontent" rows="5" cols="20"></textarea></td></tr>
                             <tr><td>上次图片</td><td><input name="fphoto" type="file" ></td></tr>
                             <tr><td><input type="submit" value="提交" name="submit"></td></tr>
                         </table>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
