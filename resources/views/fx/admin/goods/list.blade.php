@extends('fx.admin.layouts.app')
@section('title')商品列表@endsection
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
                    <div class="col-sm-2">
                      <select class="form-control input-sm" id="searchBrand" name="brand">
                        <option value="">-商品品牌-</option>
                        @foreach ($brandSelects as $select)
                        <option value="{{$select->id}}" 
                        @if(isset($_GET['brand'])) 
                          @if($_GET['brand'] == $select->id) 
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
                    <button type="button" onclick="search({{$lists->currentPage()}},['searchName','searchCategory','searchBrand','searchGroup']);" class="btn btn-default">
                    <i class="fa fa-search"></i>
                    </button>
                    </div>
                </div>
            </div>
            <div class="box-tools">
              <a href="{{ url('admin/goods/list/create') }}"><button type="button" class="btn btn-block btn-success btn-sm" id="addUser">新建商品</button></a>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
              <tbody><tr>
                <th>复选框</th>
                <th>编号</th>
                <th>商品分类</th>
                <th>商品品牌</th>
                <th>商品名称</th>
                <th>价格</th>
                <th>运费</th>
                <th>库存</th>
                <th>产地</th>
                <th>作用</th>
                <th>积分使用</th>
                <th>状态</th>
                <th>操作</th>
              </tr>
              @foreach ($lists as $k => $list)
              <tr>
                <td><input type="checkbox" class="check" value="{{$list->id}}"></td>
                <td>{{$k + 1}}</td>
                <td>{{$list->category_name}}</td>
                <td>{{$list->brand_name}}</td>
                <td>{{$list->name}}</td>
                <td>{{sprintf('%.2f', $list->price)}}</td>
                <td>{{sprintf('%.2f', $list->delivery_price)}}</td>
                <td>{{$list->stock}}</td>
                <td>{{$list->origin}}</td>
                <td>{{$list->effect}}</td>
                <td>@if($list->grade) 是 @else 否 @endif</td>
                <td>@if($list->state) 上架 @else 已下架 @endif</td>
                <td>
                  <div style="color: #dd4b39">
                  <a href="{{url('admin/goods/list')}}/{{$list->id}}/edit">
                  <i class="fa fa-edit" style="margin-right: 5px;cursor: pointer;"></i></a>
                  <i class="fa fa-trash-o" onclick="del({{$list->id}});" style="margin-right: 5px;cursor: pointer;"></i>
                  </div>
               </td>
              </tr>
              @endforeach
              <tr>
                <td><button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></td>
                <td><button type="button" onclick="dels();" class="btn btn-block btn-default btn-sm">删除</button></td>
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
