@extends('fx.admin.layouts.app')
@section('title')商品评论@endsection
@section('t1')商品管理@endsection
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
            <div class="input-group input-group-sm" style="width: 80%;">
                <div class="row">
                    <div class="col-sm-2">
                      <select class="form-control input-sm" id="searchCategory" name="category">
                        <option value="">-商品分类-</option>
                        @foreach ($categorySelects as $select)
                        <option value="{{$select->id}}" 
                        @if(isset($_GET['category'])) 
                          @if($_GET['category'] == $select->id) 
                            selected 
                          @endif 
                        @endif >
                        {{$select->name}}
                        </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-sm-3" style="padding: 0px;">
                    <input type="text" name="name" class="form-control pull-right input-sm" id="searchName" placeholder="请输入商品名称搜索" value="{{isset($_GET['name'])? $_GET['name']:''}}">
                    </div>
                    <div class="input-group-btn">
                    <button type="button" onclick="search({{$lists->currentPage()}},['searchName','searchCategory']);" class="btn btn-default">
                    <i class="fa fa-search"></i>
                    </button>
                    </div>
                </div>
            </div>
<!--             <div class="box-tools">
              <a href="{{ url('admin/goods/list/create') }}"><button type="button" class="btn btn-block btn-success btn-sm" id="addUser">新建</button></a>
            </div> -->
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
              <tbody><tr>
                <!-- <th>复选框</th> -->
                <th>编号</th>
                <th>商品分类</th>
                <th>商品</th>
                <th>评论日期</th>
                <th>用户</th>
                <th>评分</th>
                <th>内容</th>
                <th>操作</th>
              </tr>
              @foreach ($lists as $k => $list)
              <tr>
                <!-- <td><input type="checkbox" class="check" value="{{$list->id}}"></td> -->
                <td>{{$k + 1}}</td>
                <td>{{$list->category_name}}</td>
                <td>{{$list->product_name}}</td>
                <td>{{$list->created_at}}</td>
                <td>{{$list->user_name}}</td>
                <td>{{$list->grade}}</td>
                <td>{{$list->content}}</td>
                <td>
                  <div style="color: #dd4b39">
                  <a href="{{url('admin/goods/comment')}}/{{$list->id}}">查看</a>
<!--                   <i class="fa fa-trash-o" onclick="del({{$list->id}});" style="margin-right: 5px;cursor: pointer;"></i>
                  </div> -->
               </td>
              </tr>
              @endforeach
<!--               <tr>
                <td>
                    <button type="button" class="btn btn-default btn-sm checkbox-toggle">
                  <i class="fa fa-square-o"></i>
                </td>
                <td>
                    <button type="button" onclick="dels();" class="btn btn-block btn-default btn-sm">删除</button>
                </td> -->
                <th colspan="14">
                  <ul class="pagination pagination-sm no-margin pull-right">
                      {{ $lists->appends(['name' => '','category'=> ''])->links() }}
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
