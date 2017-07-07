@extends('layouts.app')

@section('title') 团购活动 @endsection

@section('css')
@endsection

@section('script')
    @parent
    <script type="text/javascript" src="{{ url('fx/common/dropload.js') }}"></script>
    <script>
        $(function () {
            var page = 0;
            $('.many').dropload({
                scrollArea : $('.many'),
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
                var url = 'http://'+window.location.host+'/home/activity/many/data'
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
                            $('.many').find('.many_nodata').remove()
                            $('.many').append(`
                            <div class="many_nodata txt-c">
                                你的购物车还没有商品，快去<a href="{{url('')}}">首页</a>看看吧
                            </div>`)
                        }
                    }
                    if (type == 'up') {
                        $('.many_list').html(template);
                    } else {
                        $('.many_list').append(template);
                    }
                    // 设置倒计时
                    $('p.start').each(function () {
                        var $this = $(this)
                        setInterval(function () {
                            var now = Date.now()
                            var times = countdown($this.data('end') - now)
                            $this.find('.hour').text(times.hour)
                            $this.find('.min').text(times.min)
                            $this.find('.second').text(times.second)
                        }, 1000)
                    })
                    me.resetload();
                    if (type == 'up') {
                        me.unlock();
                        me.noData(false);
                    }
                })
            }
            //遍历数据到模版
            function dataForeach(data){
            	var template = '';
                var type = '' // 对应的样式名称
                var now = Date.now()
            	data.forEach(function (v) {
                    var manyStart = new Date(v.date_start).getTime()
                    var manyEnd = new Date(v.date_end).getTime()
                    if (now > manyEnd) {
                        template += `<div class="many_wrapper mb-20 clearfix over">`
                    } else {
                        template += `<div class="many_wrapper mb-20 clearfix">`
                    }
                    // 判断活动的时间
                    if (now < manyStart) {
                        type = 'before'
                    } else if (now >= manyStart && now <= manyEnd) {
                        type = 'start'
                    } else if (now > manyEnd) {
                        type = 'over'
                    }
                    template += `<div class="many_left pull-left">
                                    <h1 class="fz-20 chayefont">${v.name}</h1>
                                    <p class="${type} fz-14 mt-10" data-start="${manyStart}" data-end="${manyEnd}">`
                    if (type == 'start') {
                        var times = countdown(manyEnd - now)
                        template += `<time class="hour fz-14">${times.hour}</time><b class="ml-10 mr-10">:</b><time class="min fz-14">${times.min}</time><b class="ml-10 mr-10">:</b><time class="second fz-14">${times.second}</time>`
                    } else if (type == 'before') {
                        template += `<time class="mr-10">${v.date_start.split(' ')[0]}</time>活动即将开始`
                    } else if (type == 'over') {
                        template += `活动已结束`
                    }
                    template +=     `</p>
                                </div>
                                <div class="many_right pull-right">
                                    <p class="chayefont">全场<span class="price">${v.price}</span>元</p>
                                    <a href="javascript:;" class="txt-c ${type} mt-10 mb-10 chayefont">${type == 'over' ? '活动已结束' : '去看看'}</a>
                                </div>`
                    template += `<div class="many_desc">${v.desc}</div>
                        </div>`
                })
                return template;
            }

            // 计算时分秒并获取时分秒
            // 参数是毫秒戳
            function countdown (date) {
                var hour = parseInt(date / 1000 / 3600)
                var min = parseInt(date / 1000 / 60 % 60)
                var second = parseInt(date / 1000 % 60)
                hour = hour < 10 ? '0' + hour : hour
                min = min < 10 ? '0' + min : min
                second = second < 10 ? '0' + second : second
                // $('.hour').text(hour)
                // $('.min').text(min)
                // $('.second').text(second)
                return {
                    hour: hour,
                    min: min,
                    second: second
                }
            }
        })
    </script>
@endsection

@section('content')
	@include("layouts.header-info")
	<div class="many container">
        <div class="many_list">
<!--             <div class="many_wrapper mb-20 clearfix">
                <div class="many_left pull-left">
                    <h1 class="fz-20 chayefont">活动名称</h1>
                    <p class="before fz-14 mt-10"><time class="mr-10">0000-00-00</time>活动即将开始</p>
                </div>
                <div class="many_right pull-right">
                    <p class="chayefont">全场<span class="price">88.88</span>元</p>
                    <a href="javascript:;" class="txt-c before mt-10 mb-10 chayefont">去看看</a>
                </div>
                <div class="many_desc">
                    <img src="{{url('/fx/images/user_info_bg.png')}}" alt="">
                </div>
            </div>
            <div class="many_wrapper mb-20 clearfix">
                <div class="many_left pull-left">
                    <h1 class="fz-20 chayefont">活动名称</h1>
                    <p class="start fz-14 mt-10">
                        距离活动结束还有
                        <time class="hour fz-14">00</time><b class="ml-10 mr-10">:</b><time class="min fz-14">00</time><b class="ml-10 mr-10">:</b><time class="second fz-14">00</time>
                    </p>
                </div>
                <div class="many_right pull-right">
                    <p class="chayefont">全场<span class="price">88.88</span>元</p>
                    <a href="javascript:;" class="txt-c start mt-10 mb-10 chayefont">去看看</a>
                </div>
                <div class="many_desc">
                    <img src="{{url('/fx/images/user_info_bg.png')}}" alt="">
                </div>
            </div>
            <div class="many_wrapper mb-20 clearfix over">
                <div class="many_left pull-left">
                    <h1 class="fz-20 chayefont">活动名称</h1>
                    <p class="over fz-14 mt-10">活动已结束</p>
                </div>
                <div class="many_right pull-right">
                    <p class="chayefont">全场<span class="price">88.88</span>元</p>
                    <a href="javascript:;" class="txt-c over mt-10 mb-10 chayefont">活动已结束</a>
                </div>
                <div class="many_desc">
                    <img src="{{url('/fx/images/user_info_bg.png')}}" alt="">
                </div>
            </div> -->
        </div>
	</div>
	@include("layouts.footer")
@endsection



<script language="javascript" type="text/javascript"> 
var interval = 1000; 
function ShowCountDown(year,month,day,divname) 
{ 
var now = new Date(); 
var endDate = new Date(year, month-1, day); 
var leftTime=endDate.getTime()-now.getTime(); 
var leftsecond = parseInt(leftTime/1000); 
//var day1=parseInt(leftsecond/(24*60*60*6)); 
var day1=Math.floor(leftsecond/(60*60*24)); 
var hour=Math.floor((leftsecond-day1*24*60*60)/3600); 
var minute=Math.floor((leftsecond-day1*24*60*60-hour*3600)/60); 
var second=Math.floor(leftsecond-day1*24*60*60-hour*3600-minute*60); 
var cc = document.getElementById(divname); 
cc.innerHTML = "脚本之家提示距离"+year+"年"+month+"月"+day+"日还有："+day1+"天"+hour+"小时"+minute+"分"+second+"秒"; 
} 
window.setInterval(function(){ShowCountDown(2010,4,20,'divdown1');}, interval); 
</script> 

<div id="divdown1"></div> 

