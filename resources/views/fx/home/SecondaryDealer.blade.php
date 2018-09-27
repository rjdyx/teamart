@extends('layouts.app')

@section('title') 添加二级经销商 @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('fx/mui/mui.picker.css') }}">
    <style>
        .mySelect{
            border:0px;
            height:100%;
            border-radius: 0.1rem;
            direction: rtl;
            appearance:none;
            -moz-appearance:none;
            -webkit-appearance:none;
        }
        #userlistpanel{
            height:100%;
            background: rgba(0,0,0,0.1);
        }
    </style>
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('fx/mui/mui.css') }}"> -->
@endsection

@section('script')
    @parent
    <!-- <script src="http://localhost:8080/fx/build/resizeImg.js"></script> -->
    <script src="{{url('/fx/build/valid.js')}}"></script>
    <script src="{{url('/fx/build/resizeImg.js')}}"></script>
    <script src="{{ asset('fx/js/fixInput.js') }}"></script>
    <script src="{{ asset('fx/mui/js/mui.min.js') }}"></script>
    <script src="{{ asset('fx/mui/js/mui.picker.min.js') }}"></script>
    <!-- <script src="{{ asset('fx/mui/js/data.city.js') }}"></script> -->
    <script src="{{url('/fx/js/fixInput.js')}}"></script>
    <script>
        $(function () {
            //表单提交
            $(".J_submit").click(function(){
                if(!changeselect(document.getElementById("secondarydealername"))){
                    return;
                }
                if(!changeselect(document.getElementById("message"))){
                    return;
                }
                submitForm();
            });
            _valid.bindEvent(['secondarydealername', 'scale' , 'message']);
            function submitForm(){
                var form = document.forms['form'];
                var params = {
                    secondarydealername: form['secondarydealername'].value,
                    scale: form['scale'].value,
                    message: form['message'].value,
                    id: form['id'].value
                };
                submitAjax(params);
            }
            function submitAjax (params) {
                var url = $("form").attr('action');//当前编辑id
                if (_valid.validForm(params)) {
                    fxPrompt.loading('保存中');
                    ajax('post', url, params)
                        .then(function (resolve) {
                            if (resolve.status == 200) {
                                fxPrompt.message('保存成功', 'http://' + window.location.host + '/home/'+'@if(Auth::user()->type == 2)user/@endif'+'management/dealer');
                            } else {
                                fxPrompt.message(resolve.message, 'http://' + window.location.host + '/home/'+'@if(Auth::user()->type == 2)user/@endif'+'management/dealer');
                            }
                        });
                } else {
                    str = `请填写正确信息`;
                    fxPrompt.message(str);
                }
            }
            $("#userlist li").click(function(){
                //获取被点击项的值 与显示值
                clickvalue = $(this).text();
                // console.log(clickvalue);
                $("#secondarydealername").val(clickvalue);
                //隐藏选择框
                showselectpanel();
            });
            //阻止点击冒泡
            $("#findtext").click(function (e) {
                if(e && e.stopPropagation){
                    //W3C取消冒泡事件
                    e.stopPropagation();
                }else{
                    //IE取消冒泡事件
                    window.event.cancelBubble = true;
                }
            });
        });
        function changeselect(obj) {
            if(obj.value == ""){
                $("#secondarydealername").prev().css('color','red');
                return false;
            }else{
                $("#secondarydealername").prev().css('color','#000');
                return true;
            }
        }
        //显示用户选择
        function showselectpanel() {
            if($("#userlistpanel").css('display') == "none") {
                $("#userlistpanel").css('display', 'block');
            }else{
                $("#userlistpanel").css('display', 'none');
                //页面隐藏后 输入框清空
                $("#findtext").val("");
                //列表恢复
                findlivalue(document.getElementById("findtext"));
            }
        }
        // 筛选
        function findlivalue(obj) {
            //获取所有可选节点信息
            var userlist = $("#userlist").children();
            //获取输入的信息
            var query_text = obj.value;
            //遍历节点信息
            $.each(userlist,function(key,value){
                //按匹配查找
                if($(value).html().indexOf(query_text) == -1){
                    //隐藏匹配不成功项
                    $(value).css('display','none');
                }else{
                    //显示匹配成功项
                    $(value).css('display','block');
                }
            });
        }

    </script>
@endsection

@section('content')

    @include("layouts.header-info")

    <?php
    $img = Auth::user()->img;
    if (!strstr($img,'http') && !empty($img)) $img = url('').'/'.$img;
    ?>
    <div class="container useredit relative">
        <div class="useredit_info mb-10 relative">
            <label for="img" class="block avatar">
                <img class="w-100" id="avatar" src="{{$img}}">
            </label>
            <p class="useredit_name white fz-20 txt-c chayefont">{{Auth::user()->name}}</p>
        </div>
        @if(Auth::user()->type == 1)
            <form action="{{url('/home/application/information')}}" id="form" enctype="multipart/form-data">
        @else
            <form action="{{url('/home/user/application/information')}}" id="form" enctype="multipart/form-data">
        @endif
            @if(isset($applicationInformationinfo->name ))
                <input type="hidden" name="id" value="{{$applicationInformationinfo->id}}">
            @endif
            <div class="form_item fz-16 chayefont" onclick="showselectpanel()">
                <label for="secondarydealername">姓名</label>
                <input type="text" class="pull-right txt-r color-8C8C8C block chayefont" name="secondarydealername" id="secondarydealername" autocomplete="off" placeholder="请选择邀请用户" value="@if(isset($applicationInformationinfo->name )) {{$applicationInformationinfo->name}} @endif">
            </div>
            <div class="form_item fz-16 chayefont">
                <label for="scale">提成</label>
                <input type="tel" name="scale" id="scale" data-required="true" class="pull-right txt-r color-8C8C8C block chayefont" autocomplete="off" placeholder="请输入提成比例" value="@if(isset($applicationInformationinfo->scale )) {{$applicationInformationinfo->scale}} @endif">
            </div>
            <div class="form_item fz-16 chayefont" style="height: 1.8rem;">
                <label for="message" style="line-height: 1.8rem;">消息</label>
                <textarea name="message" id="message" rows="5" cols="30" style="border:0px;" data-required="true" class="pull-right color-8C8C8C block chayefont" autocomplete="off" placeholder="请输入你要发送给对方的消息，以便对方确认！">@if(isset($applicationInformationinfo->message )) {{$applicationInformationinfo->message}} @endif</textarea>
            </div>
        </form>
        @if(Auth::user()->type == 1)
            @if(isset($applicationInformationinfo->name))
                <div class="chayefont bottom_btn white txt-c block fz-18 J_submit">保存邀请信息</div>
            @else
                <div class="chayefont bottom_btn white txt-c block fz-18 J_submit">发送邀请</div>
            @endif
        @elseif(Auth::user()->type == 2)
            @if(isset($applicationInformationinfo->name))
                <div class="chayefont bottom_btn white txt-c block fz-18 J_submit">保存申请请信息</div>
            @else
                <div class="chayefont bottom_btn white txt-c block fz-18 J_submit">发送申请</div>
            @endif
        @endif
        <div class="chayefont bottom_btn white txt-c block fz-18" id="userlistpanel" style="display: none;">
            <div style="height: 25%;opacity:0;border:1px solid blue;" onclick="showselectpanel()"></div>
            <div style="height:75%;background:rgb(199,194,178);overflow: auto;" >
                <div style="width:100%;height:0.8rem;position: fixed;background:rgb(199,194,178);" onclick="showselectpanel()">
                    <input type="text" id="findtext" style="height:0.5rem;text-align: center;" placeholder="请输入查询条件" oninput="findlivalue(this)">
                </div>
                <ul id="userlist" style="margin-top: 0.8rem;">
                    @foreach($userlist as $userlistitem)
                        <li>{{$userlistitem->name}}</li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
@endsection

