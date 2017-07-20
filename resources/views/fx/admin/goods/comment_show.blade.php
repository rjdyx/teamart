@extends('fx.admin.layouts.app')
@section('title')评论详情@endsection
@section('t1')商品管理@endsection
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
    <section class="content">
      <div class="row">
        <!-- 新增商品品牌 -->
        <div class="col-xs-12">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">评论详情操作</h3>
            </div>

            <form class="form-horizontal" action="{{url('admin/goods/comment')}}" method="POST">
              {{ csrf_field() }}
              <input type="hidden" name="id" value="{{$show->id}}">
              <input type="hidden" name="bid" value="{{$show->user_id}}">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>评论:</label>
                  <div class="col-sm-4">
                    {{$show->content}}
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>图片:</label>
                  <div class="col-sm-4">
                    @if ($show->img)<a class="J_show_imgs" href="javascript:;" data-imgs="{{ $show->img }} ">查看图片</a>@else 暂无图片 @endif
                  </div>
                </div>
                @foreach($replys as $reply)
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">
                    {{$reply->aname}} 回复 {{$reply->bname}} ({{$reply->created_at}}) :
                    </label>
                    <div class="col-sm-4">
                    {{$reply->content}}
                    </div>
                  </div>
                @endforeach
                <div class="form-group">
                  <label class="col-sm-3 control-label">回复:</label>
                  <div class="col-sm-4">
                    <textarea name="content" style="resize:none;" id="" cols="80" rows="8"></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-10">
                    <button type="submit" class="btn btn-success btn-100">确认</button>
                    <button type="reset" class="btn btn-success btn-100">重置</button>
                    <a href="{{ url('admin/goods/comment') }}"><button type="button" class="btn btn-success btn-100" id="cancel_addAgent">取消</button></a>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            </form>
          </div>
        </div>
        <!-- /新增代理商角色 -->
      </div>
    </section>
@endsection

