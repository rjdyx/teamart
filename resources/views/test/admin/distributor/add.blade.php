@extends('layouts.newapp')

@section('content')
    <form action='{{url('/admin/distributor/add')}}' method="post">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">添加分销员</h3>

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

                        <th>设置为分销员</th>
                    </tr>
                    </thead>
                    <tbody>


                    @foreach($users->where('type','!=',1) as $user)
                        <tr>
                            <th></th>
                            <th>{{$user->id}}</th>
                            <th>{{$user->name}}</th>
                            <th>{{App\user::TYPE[$user->type]}}</th>

                            <th><input type="checkbox" name="isDistributor[]" value="{{$user->id}}">



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



        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" value="提交">
    </form>
@endsection