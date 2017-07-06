@extends('fx.admin.layouts.app')

@section('title')积分商品@endsection
@section('t1')促销管理@endsection

@section('css')
@endsection

@section('script')
    @parent
@endsection

@section('content')
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header">
            <div class="input-group input-group-sm" style="width:30%;">
                <div class="row">

                  <div class="col-sm-12"><input type="text" name="name" class="form-control pull-right input-sm" placeholder="请输入商品名称搜索" value="{{isset($_GET['name'])?$_GET['name']:''}}" id="searchName"></div>
                </div>
                <div class="input-group-btn">
                  <button type="submit" class="btn btn-default"  onclick="search({{$lists->currentPage()}},['searchName']);"><i class="fa fa-search"></i></button>
                </div>
            </div>
            <div class="box-tools">
             <a href="{{url('/admin/activity/mark/create')}}"> <button type="button" class="btn btn-block btn-success btn-sm" id="addUser">添加商品</button></a>
            </div>
          </div>

          <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
              <tbody><tr>
                <th>多选框</th>
                <th>编号</th>
                <th>商品图片</th>
                <th>商品名称</th>
                <th>价格</th>
                <th>状态</th>
                <th>库存</th>
                <th>操作</th>
              </tr>
              @foreach($lists as $k=>$list)
              <tr>
                <td><input type="checkbox" class="check" value="{{$list->id}}"></td>
                <td>{{$k+1}}</td>
                <td><img src="{{url('')}}/{{$list->thumb}}" alt="" width="40px" height="35px"></td>
                <td>{{$list->name}}</td>
                <td>&yen; {{$list->price}}</td>
                <td>@if($list->state==1) 有货 @else缺货 @endif </td>
                <td>{{$list->stock}}</td>
                <td><div style="color: #dd4b39">
                  <i class="fa fa-trash-o" onclick="del({{$list->id}});"  style="margin-right: 5px;cursor: pointer;"></i>
                </div>
               </td>
              </tr>
              @endforeach

              <tr>
                <td><button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o">全选</i></td>
                  <td><button type="button" onclick="dels();" class="btn btn-block btn-default btn-sm">删除</button></td>
                <th colspan="12">
                  <ul class="pagination pagination-sm no-margin pull-right">
                      {{ $lists->appends(['name' => '','state'=>''])->links() }}
                      共{{ $lists->lastPage() }}页
                  </ul>
                </th>
              </tr>
            </tbody></table>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
