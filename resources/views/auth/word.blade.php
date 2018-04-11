@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">注册口令</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/getword') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label">口令：</label>
                            <div class="col-md-6">
                                <input id="name" type="text" name="word">
                                <input type="submit" value="提交">
                                <span style="color:red">
                                    @if(!empty(session('error')))
                                    {{session('error')}}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
