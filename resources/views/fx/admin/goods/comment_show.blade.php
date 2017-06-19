@extends('fx.admin.layouts.app')
@section('title')评论详情@endsection
@section('t1')商品管理@endsection
@section('css')@endsection
@section('script')
    @parent
@endsection
@section('content')
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

