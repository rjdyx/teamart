@extends('fx.admin.layouts.app')

@section('title')用户反馈@endsection
@section('t1')管理@endsection

@section('css')
    <!-- 图片弹窗 -->
    <link rel="stylesheet" type="text/css" href="{{url('/admin/css/show_box.css')}}">
@endsection

@section('script')
    @parent
    <!-- 图片弹窗 -->
    <script src="{{url('admin/js/showBox.js')}}"></script>
@endsection

@section('content')
            <!-- 图片弹窗 -->
            <div class="show_box">
                <div class="show_bg J_hide_imgs"></div>
                <div class="show_img" data-imgs="" data-idx="">
                    <a href="javascript:;" class="J_left pull-left"><i class="fa fa-angle-left"></i></a>
                    <div class="img_box">
                        <img src="" alt="">
                    </div>
                    <a href="javascript:;" class="J_right pull-right"><i class="fa fa-angle-right"></i></a>
                </div>
            </div>






            <!-- Main content of agentRole-->
            <section class="content">
                <div class="row">
                    <!-- 代理商角色列表 -->
                    <div class="col-xs-12">
                        <div class="box box-success">
                            <div class="box-header">
                                <div class="input-group input-group-sm" style="width: 470px;">
                                    <form action="{{url("admin/system/feedback/")}}" method="get">
                                    <select class="form-control input-sm" name="sort">
                                        @if(empty($_GET['sort']))
                                            <option value="0"  >默认排序</option>
                                            <option value="1"  >按反馈时间降序</option>
                                            <option value="2"  >按反馈时间升序</option>
                                        @else
                                        <option value="0">默认排序</option>

                                        <option value="1"
                                                @if($_GET['sort'] == 1)
                                                selected
                                                @endif
                                        >按反馈时间降序</option>
                                        <option value="2"
                                                @if($_GET['sort'] == 2)
                                                selected
                                                @endif
                                        >按反馈时间升序</option>
                                        @endif
                                        </select>


                                        <button type="submit" class="btn btn-block btn-default btn-sm" style="width: 50px;">排序</button>
                                        </form>
                                </div>


                            </div>
                            <!-- /.box-header -->
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-hover">


                                    <tbody><tr>
                                        <th><!-- <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button> --></th>
                                        <th>编号</th>
                                        <th>用户ID</th>
                                        <th>反馈内容</th>
                                        <th>联系方式</th>
                                        <th>反馈图片</th>
                                        <th>反馈时间</th>
                                        <th>操作</th>
                                    </tr>


                                    @foreach($lists  as $k => $list)
                                    <tr>

                                        <td><input type="checkbox"class="check" value="{{$list->id}}"></td>
                                        <td>{{$k + 1}}</td>
                                        <td><i class="fa fa-times">{{$list->user_id}}</i></td>
                                        <td><i class="fa fa-check fa_skin">{{$list->content}}</i></td>
                                        <td>{{$list->contact}}</td>
                                        <td>@if ($list->img)<a class="J_show_imgs" href="javascript:;" data-imgs="{{ $list->img }} ">查看图片</a>@else 暂无图片 @endif</td>
                                        <td>{{$list->date}}</td>
                                        <td>
                                                <i class="fa fa-trash-o" onclick="del({{$list->id}});"style="margin-right: 5px;cursor: pointer;"></i></div></td>
                                    </tr>
                                    @endforeach



                                    <tr>
                                        <td><button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></td>

                                        <td><button type="button" onclick="dels();" class="btn btn-block btn-default btn-sm">删除</button></td>
                                        <th colspan="5">

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



@endsection
