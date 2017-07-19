@extends('fx.admin.layouts.app')

@section('title')用户反馈@endsection
@section('t1')管理@endsection

@section('css')
    <style type="text/css">
        .show_box {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 10000;
            display: none;
        }
        .show_bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }
        .show_img {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 860px;
            height: 600px;
            line-height: 600px;
            text-align: center;
            background-color: #fff;
        }
        .show_img a {
            display: block;
            height: 100%;
            width: 30px;
        }
        .show_img a i {
            font-size: 30px;
            vertical-align: middle;
        }
        .img_box {
            float: left;
            width: 800px;
            height: 600px;
        }
        .img_box img {
            max-width: 800px;
            max-height: 600px;
        }
    </style>
@endsection

@section('script')
    @parent
    <script>
        $(function () {
            // 显示图片弹窗
            $('.J_show_imgs').on('click', function () {
                if ($(this).data('imgs')) {
                    var imgs = $(this).data('imgs').split(',')
                    $('.show_img').data('imgs', imgs)
                    $('.show_img').data('idx', 0)
                    $('.show_img').find('img').attr('src', '{{url('')}}/' + imgs[0])
                    $('.show_box').show()
                }
            })
            // 隐藏图片弹窗
            $('.J_hide_imgs').on('click', function () {
                $('.show_img').data('imgs', '')
                $('.show_img').data('idx', 0)
                $('.show_img').find('img').attr('src', '')
                $('.show_box').hide()
            })
            // 左切换
            $('.J_left').on('click', function () {
                console.log($(this).parent().data('imgs'))
                console.log($(this).parent().data('idx'))
                var imgs = $(this).parent().data('imgs')
                var idx = $(this).parent().data('idx')
                if (idx == 0) {
                    $('.show_img').data('idx', imgs.length-1)
                    $('.show_img').find('img').attr('src', '{{url('')}}/' + imgs[imgs.length-1])
                } else {
                    $('.show_img').data('idx', idx-1)
                    $('.show_img').find('img').attr('src', '{{url('')}}/' + imgs[idx-1])
                }
            })
            // 右切换
            $('.J_right').on('click', function () {
                var imgs = $(this).parent().data('imgs')
                var idx = $(this).parent().data('idx')
                if (idx == imgs.length-1) {
                    $('.show_img').data('idx', 0)
                    $('.show_img').find('img').attr('src', '{{url('')}}/' + imgs[0])
                } else {
                    $('.show_img').data('idx', idx+1)
                    $('.show_img').find('img').attr('src', '{{url('')}}/' + imgs[idx+1])
                }
            })
        })
    </script>
@endsection

@section('content')
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
