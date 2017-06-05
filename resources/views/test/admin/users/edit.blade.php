@extends('layouts.newapp')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Panel title</h3>
    </div>
    <div class="panel-body">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="panel-body">
            <form action={{url('admin/users/'.$user->id.'')}} method="POST">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                用户名：{{$user->name}}<br>
                email:{{$user->email}}<br>
                @if($user->isLock==0)
                    是否锁定：<input name="isLock" type="radio" value="0"  checked />否 <input name="isLock" type="radio" value="1" />是<br>
                @else
                    是否锁定：<input name="isLock" type="radio" value="0"   />否 <input name="isLock" type="radio" value="1" checked/>是<br>
                @endif
                <input type="submit">
            </form>
        </div>
    </div>
</div>
@endsection