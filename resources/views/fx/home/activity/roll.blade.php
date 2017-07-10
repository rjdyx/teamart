@extends('layouts.app')

@section('title') 优惠券 @endsection

@section('css')
@endsection

@section('script')
    @parent
    <script type="text/javascript" src="{{ url('fx/common/dropload.js') }}"></script>
    <script>
        $(function () {
            var page = 0;
            $('.roll').dropload({
                scrollArea : $('.roll'),
                domUp : {
                    domClass   : 'dropload-up',
                    domRefresh : '<div class="dropload-refresh">↓下拉刷新</div>',
                    domUpdate  : '<div class="dropload-update">↑释放更新</div>',
                    domLoad    : '<div class="dropload-load"><span class="loading"></span>加载中...</div>'
                },
                domDown : {
                    domClass   : 'dropload-down',
                    domRefresh : '<div class="dropload-refresh">↑上拉加载更多</div>',
                    domLoad    : '<div class="dropload-load"><span class="loading"></span>加载中...</div>',
                    domNoData  : '<div class="dropload-noData">没有更多数据了</div>'
                },
                loadUpFn : function(me){
                    getListData(me, 'up')
                },
                loadDownFn : function(me){
                    getListData(me, 'down')
                },
                threshold : 50
            });
            function getListData (me, type) {
                if (type == 'down') {
                    page++
                } else {
                    page = 1
                    $('.dropload-down').show()
                }
                var url = "http://"+window.location.host+'/home/activity/roll/data'
                ajax('get', url, {page: page}).then(function (res) {
                    var template = ''
                    var data = res.data
                    if (data.length > 0) {
                        template = dataForeach(data);
                    } else {
                        me.lock();
                        me.noData();
                        if (page == 1) {
                            $('.dropload-down').hide()
                            $('.roll').find('.roll_nodata').remove()
                            $('.roll').append(`
                            <div class="roll_nodata txt-c">
                                暂时还没有优惠券
                            </div>`)
                        }
                    }
                    if (type == 'up') {
                        $('.roll_list').html(template);
                    } else {
                        $('.roll_list').append(template);
                    }
                    // 领取的事件
                    $('.roll_get').off('click tap').on('click tap', getRoll)
                    me.resetload();
                    if (type == 'up') {
                        me.unlock();
                        me.noData(false);
                    }
                }).catch(function (err) {
                    console.dir(err)
                    prompt.message('服务器异常！请稍后再试！')
                    // me.resetload()
                    me.unlock();
                })
            }

            //遍历数据到模版
            function dataForeach(data){
            	var template = '';
                var type = '' // over为过期，used为已使用，take为已领取, get为领取
                var typetxt = ''
                var now = Date.now()
            	data.forEach(function (v) {
                    var indate = new Date(v.indate).getTime()
                    if (now > indate) {
                        type = 'over'
                        typetxt = '已过期'
                    }else if (v.user_id == null) {
                        type = 'get'
                        typetxt = '领取'
                    }else if (v.ustate > 0) {
                        type = 'used'
                        typetxt = '已使用'
                    }else if (v.user_id !== null) {
                        type = 'take'
                        typetxt = '已领取'
                    }else if (v.state <1) {
                        type = 'over'
                        typetxt = '已领完' 
                    }
                    // 缺少用户是否使用或者领取的状态判断
                    template += `
                        <li class="clearfix mb-20 ${type == 'used' || type == 'over' ? 'used' : ''}">
                            <div class="pull-left roll_info">
                                <h1 class="chayefont">${v.name}</h1>
                                <p class="roll_desc mt-10 mb-10">${v.desc}</p>
                                <p class="roll_time get txt-r">有效期至${v.indate.split(' ')[0]}</p>
                            </div>
                            <div class="pull-right roll_price">
                                <p class="roll_cut txt-c fz-20"><i class="yen mr-10">&yen;</i><span class="cut">${v.cut}</span></p>
                                <p class="roll_full txt-c mt-10 chayefont fz-14">满<span class="full">${v.full}</span>元可用</p>
                                <a href="javascript:;" rid="${v.id}" class="roll_${type} block txt-c mt-10 chayefont">${typetxt}</a>
                            </div>
                        </li>
                    `
                })
                return template;
            }

            // 获取优惠券
            function getRoll () {
                var $this = $(this)
                var id = $this.attr('rid');
                if ($this.hasClass('roll_get')) {
                    var url = "http://"+window.location.host+'/home/activity/roll/get'
                    ajax('get', url, {id: id}).then(function (res) {
                        if (res == 1) {
                            prompt.message('领取成功')
                            $this.removeClass('roll_get').addClass('roll_take').text('已领取')
                        } else if(res == 2){
                            prompt.message('该优惠券已被抢空~')
                            $this.removeClass('roll_get').addClass('roll_over').text('已领完')
                        } else {
                            prompt.message('领取失败')
                        }
                    })
                }
            }
        })
    </script>
@endsection

@section('content')
	@include("layouts.header-info")
	<div class="roll container">
        <ul class="roll_list">
        

        </ul>
	</div>
	@include("layouts.footer")
@endsection
