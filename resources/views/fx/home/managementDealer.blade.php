@extends('layouts.app')

@section('title') @endsection
@section('css')

@endsection
<style>
    .btn-add-item{
        line-height: 1rem;
        background: rgb(222,216,204);
        text-align: center;
    }
    .btn-del{
        display: block;
        text-align: center;
        border-radius: 0.1rem;
        color:#FF4100;
    }
    .edit{color:rgb(51,133,255);}
    .del{
        color:#FF4100;
    }
    .list-ul{
        display: flex;
        flex-direction: row;
        text-align: center;
        height: 0.8rem;
        line-height: 0.8rem;
        border-top:1px solid rgb(239,239,241);
    }
    li{
        flex: 1;
    }
    .menu-check{border-bottom:2px solid rgb(247,130,35);}
    #listmenu{
        display: flex;
        width: 100%;
        height: 0.8rem;
        line-height: 0.8rem;
        text-align: center;
    }
    /*超出显示省略号*/
    .overdisplay{
        text-overflow: ellipsis;white-space: nowrap;overflow: hidden;
    }

    #message{
        height:100%;
        background: rgba(0,0,0,0.2);
        display: flex;
        flex-direction: column;
    }
    .message_check {
        display: none;
    }
    #message .closewin{
        flex:1;
    }
    #message .message_content{
        background: rgb(199,194,178);
        max-height: 60%;
        min-height: 40%;
        overflow-y: scroll;
    }
    #message .message_header{
        background: rgb(199,194,178);
        position: fixed;
        text-align: center;
        width: 100%;
    }
    #message tip{
        display: block;
        color: #444;
        height:2em;
        line-height: 2em;
    }

    #message .message_text{
        margin-top:2.5em;
        line-height: 16pt;
        text-align: left;
        padding:1em;
        padding-top:0px;
    }

</style>
@section('script')
    @parent
    <script type="text/javascript" src="{{ url('fx/js/dropload.min.js') }}"></script>
    <script>
        ajax('get','/home/maxparternumber/beyond').then(function (res) {
            if(res.status != 200 || res.number == 0){
                $(".J_submit").hide();
            }
        });
        var header1node = `
                <div class="userassets_container_warpper w-100 p-10">
                        <ul class="list-ul" style="border-bottom:1px solid rgb(239,239,241);">
                            <li>
                                <p>用户名</p>
                            </li>
                            <li>
                                <p>提成</p>
                            </li>
                            <li>
                                <p>联系电话</p>
                            </li>
                            <li>
                                <p>操作</p>
                            </li>
                        </ul>
                        <div style="overflow:scroll;max-height: 100%;" id="datapanel">

                        </div>
                </div>
            `;
        var header3node = `
                <div class="userassets_container_warpper w-100 p-10">
                        <ul class="list-ul" style="border-bottom:1px solid rgb(239,239,241);">
                            <li>
                                <p>申请人</p>
                            </li>
                            <li>
                                <p>提成</p>
                            </li>
                            <li>
                                <p>消息</p>
                            </li>
                            <li>
                                <p>操作</p>
                            </li>
                        </ul>
                        <div style="overflow:scroll;max-height: 100%;" id="datapanel">

                        </div>
                </div>
            `;
        var header2node = `
                <div class="userassets_container_warpper w-100 p-10">
                        <ul class="list-ul" style="border-bottom:1px solid rgb(239,239,241);">
                            <li>
                                <p>受邀人</p>
                            </li>
                            <li>
                                <p>提成</p>
                            </li>
                            <li>
                                <p>消息</p>
                            </li>
                            <li>
                                <p>操作</p>
                            </li>
                        </ul>
                        <div style="overflow:scroll;max-height: 100%;" id="datapanel">

                        </div>
                </div>
            `;
        //以下代码块是加载完成后才能执行
        $(function () {
            var url = 'dealer/information/list';//默认
            requestfunction(url);//默认请求第一个url
            $("#listmenu li").click(function () {
                //调用页面初始化函数
                initrequestfunction(this);
            });
        });
        //页面初始化函数
        function initrequestfunction(obj) {
            //导航效果
            $(obj).addClass("menu-check").siblings().removeClass("menu-check");
            //设置请求路由
            switch ($(obj).attr('id')){
                case 'userlist':
                    url = 'dealer/information/list';
                    break;
                case 'applicationlist':
                    url = 'application/information/list';
                    break;
                case 'invitelist':
                    url = 'invite/information/list';
                    break;
            }
            requestfunction(url);
        }
        //列表请求函数
        function requestfunction(url) {
            $(".userassets_list").html("<div class='list_nodata txt-c'>加载中...</div>");
            ajax('get','http://'+window.location.host+'/home/'+url)
                .then(function (res) {
                    // console.log(url);
                    if(res.length){
                        //先对其进行清空
                        $(".userassets_list").html("");
                        //然后进行数据添加
                        let id = 0;
                        let display = true;
                        $.each(res,function (index,value) {
                            // console.log(value);
                            id = value.id;
                            //对数据进行遍历
                            //添加头部信息
                            if(url == 'dealer/information/list'){
                                if(display) {
                                    $(".userassets_list").append(header1node);
                                    display = false;
                                }
                                $("#datapanel").append(`
                                    <ul class="list-ul">
                                        <li>
                                            <p>${value.name}</p>
                                        </li>
                                        <li>
                                            <p>${value.scale}</p>
                                        </li>
                                        <li>
                                            <p>${value.phone}</p>
                                        </li>
                                        <li>
                                            <p><a href="#" class="btn-del" onclick="deleteAssociation('deleteassociation',${id})">删除关联</a></p>
                                        </li>
                                    </ul>
                                `);
                            }else{
                                if(url == 'application/information/list') {
                                    if(display) {
                                        $(".userassets_list").append(header2node);
                                        display = false;
                                    }
                                    let href = '/home/secondary/dealer/edit/'+id;
                                    let node = `<a href="${href}" class="edit" >修改 </a> | <a href="#" class="del" onclick="deleteAssociation('delete',${id})"> 删除</a>`;
                                    showcontrollist(value,node);
                                }else{
                                    if(display) {
                                        $(".userassets_list").append(header3node);
                                        display = false;
                                    }
                                    showcontrollist(value,`<a href="#" class="edit" onclick="deleteAssociation('accept',${id})">接受 </a> | <a href="#" class="del" onclick="deleteAssociation('refuse',${id})"> 拒绝</a>`);
                                }
                            }
                        });
                        $("#datapanel").append(`<div style="height: 1.8rem;"></div>`);
                    }else{
                        //如果数据为空
                        $(".userassets_list").html(
                            `<div class="list_nodata txt-c">暂无记录</div>`
                        );
                    }
                });
        }
        //操作列表显示函数
        function showcontrollist(value,nodevalue) {
            $("#datapanel").append(`
                <ul class="list-ul">
                    <li>
                        <p>${value.name}</p>
                    </li>
                    <li>
                        <p>${value.scale}</p>
                    </li>
                    <li style="max-width:25%;">
                        <p class="overdisplay" onclick="showMessage(this)">${value.message}</p>
                    </li>
                    <li>
                        <p style="" class="controlpanel " id="item${value.id}" ></p>
                    </li>
                </ul>
            `);
            let nodeitem = "#item"+value.id;
            //结果显示
            if(value.status == 2){
                $(nodeitem).html(nodevalue);
            }else{
                if(value.status == 1){
                    $(nodeitem).html(`<a href="#">已接受</a>`);
                }else{
                    if(value.status == 3)
                        $(nodeitem).html(`<a href="#">已失效</a>`);
                    else
                        $(nodeitem).html(`<a href="#">已拒绝</a>`);
                }
            }
        }
        //点击删除关联时的操作
        function deleteAssociation(type,id){
            // console.log(id);
            //消息提示
            //构建提示信息
            let message = '是否';
            //请求路由
            let url = '';
            //操作类型判断
            switch (type){
                case 'accept'://接受
                    message += '接受';
                    //接受路由
                    url += 'agree/invitation';
                    break;
                case 'refuse'://拒绝
                    message += '拒绝';
                    //拒绝路由
                    url += 'refuse/invitation';
                    break;
                case 'delete'://删除
                    message += '删除';
                    //删除路由
                    url += 'delete/invitation';
                    break;
                case 'deleteassociation'://删除关联
                    message += '删除关联';
                    //删除关联路由
                    url += 'disassociate';
                    break;
                default://其他操作
                    break;
            }
            //确认操作
            fxPrompt.question(message + '？', function () {
                //点击确定时才会执行这里
                // console.log(url);
                let data = {
                    id: id
                };
                ajax('post',url,data)
                    .then(function (res) {
                        if(res.start == 200){
                            //获取当前选中的列表节点
                            fxPrompt.message(res.message);
                        }else{
                            fxPrompt.message(res.message);
                        }
                        //刷新页面
                        initrequestfunction($(".menu-check")[0]);
                    });
            });
        }

        //显示全部提示消息
        function showMessage(obj) {/*提示信息需要修改*/
            console.log($("#message_box")[0].className);
            if("message_check" == $("#message_box")[0].className) {
                //显示信息的增加
                $(".message_text").text($(obj).text());
                $("#message_box").removeClass("message_check");
            }else{
                $(".message_text").text("");
                $("#message_box").addClass("message_check");
            }
        }
    </script>
@endsection

@section('content')

    @include("layouts.header-info")

    @include("layouts.backIndex")
    <div class="container useredit userassets relative">
        <div class="userassets_info relative">
            <div class="avatar">
                <img class="w-100" src="{{url('')}}/@if(Auth::user()){{Auth::user()->img}} @endif" alt="">
            </div>
            <p class="userassets_name white fz-20 txt-c chayefont">@if(Auth::user()){{Auth::user()->name}} @endif</p>
        </div>
        <div class="userassets_content mt-20 w-100" style="overflow:hidden;">
            <ul id="listmenu">
                <li class="menu-check" id="userlist">二级代理商列表</li>
                <li id="applicationlist">申请列表</li>
                <li id="invitelist">邀请列表</li>
            </ul>
            <div class="userassets_list"></div>
        </div>
        <a href="{{url('/home/secondary/dealer/add')}}" class="chayefont bottom_btn white txt-c block fz-18 J_submit"><div>添加二级经销商</div></a>
        <div id="message_box" class="message_check">
            <div class="chayefont bottom_btn txt-c" id="message">
                {{--点击关闭--}}
                <div class="closewin" onclick="showMessage(null)"></div>
                {{--主要窗口--}}
                <div class="message_content">
                    {{-- 头部信息 有按钮--}}
                    <div class="message_header" onclick="showMessage(null)">
                        <tip>点击此处关闭</tip>
                    </div>
                    <div class="message_text">
                        {{--主要信息显示--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
