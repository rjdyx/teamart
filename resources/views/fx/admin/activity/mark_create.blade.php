@extends('fx.admin.layouts.app')


@section('title')积分商品@endsection
@section('t1')活动@endsection

@section('css')

@endsection

@section('script')
    @parent

@endsection

@section('content')




            <!-- Main content of agentRole-->
            <section class="content">
                <div class="row">
                    <!-- 代理商角色列表 -->
                    <div class="col-xs-12">
                        <div class="box box-success">
                            <div class="box-header">
                                <div class="input-group input-group-sm" style="width: 470px;">
                                    <form action="{{url("admin/activity/mark/")}}" method="get">
                                    <div class="row">
                                        <div class="col-sm-4">

                                            <select class="form-control input-sm" name="sort">
                                                @if(empty($_GET['sort']))
                                                    <option value="20"  >状态</option>
                                                    <option value="21"  >有货</option>
                                                    <option value="22"  >无货</option>
                                                @else
                                                    <option value="0">状态</option>

                                                    <option value="21"
                                                            @if($_GET['sort'] == 21)
                                                            selected
                                                            @endif
                                                    >有货</option>
                                                    <option value="22"
                                                            @if($_GET['sort'] == 22)
                                                            selected
                                                            @endif
                                                    >无货</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-sm-8"><input type="text" name="table_search" class="form-control pull-right input-sm" placeholder="请输入搜索内容"></div>
                                    </div>
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>

                                    </div>
                                    </form>
                                </div>
                                <div class="box-tools">
                                    <a href="{{url("admin/activity/mark/")}}"> <button type="button" class="btn btn-block btn-success btn-sm" id="addUser">积分商品</button></a>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body table-responsive no-padding">

                                <table class="table table-hover">
                                    <tbody><tr>
                                        <th><!-- <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button> --></th>
                                        <th>编号</th>
                                        <th>商品名称</th>
                                        <th>状态</th>
                                        <th>积分使用</th>
                                        <th>库存</th>
                                        <th>描述</th>
                                        <th>当前价格</th>
                                        <th>操作</th>
                                    </tr>
                                    @foreach($lists as $k=>$list)
                                        <tr>
                                            <td><input type="checkbox" class="check" value="{{$list->id}}"></td>
                                            <td>{{$k+1}}</td>
                                            <td>{{$list->name}}</td>
                                            @if($list->state==1)
                                                <td> 有货 </td>
                                            @else
                                                <td> 缺货 </td>
                                            @endif
                                            @if($list->grade==1)
                                                <td> 可使用 </td>
                                            @else
                                                <td> 不可用 </td>
                                            @endif
                                            <td>{{$list->stock}}</td>
                                            <td>{{$list->desc}}</td>
                                            <td>{{$list->price}}</td>

                                            <td><div style="color: #dd4b39"><a href="{{url("admin/activity/mark/$list->id/edit")}}"><i class="fa fa-trash-o"  style="margin-right: 5px;cursor: pointer;"></i></a></div>
                                            </td>
                                        </tr>
                                    @endforeach

                                    <tr>
                                        <td><button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o">全选</i></td>

                                        <td><button type="button" onclick="dels();" class="btn btn-block btn-default btn-sm">添加</button></td>


                                        <th colspan="9">
                                            @if(isset($_GET['sort']))
                                                {{$lists->appends('sort',$_GET['sort'])->links()}}
                                            @else
                                                {{$lists->links()}}
                                            @endif
                                            共{{ $lists->lastPage() }}页
                                        </th>
                                    </tr>
                                    </tbody></table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /代理商角色列表 -->
                </div>
            </section>
            <!-- /.content -->

        <!-- /agentRole -->

        <!-- addagent -->

            <!-- /.content -->

@endsection
