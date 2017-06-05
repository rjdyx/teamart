$(function(){
	operation.search();
	myLoadUp.loadUpFnContainer();
});
var myLoadUp = {
	loadUpFnContainer:function(){
		var counter = 0;
	    // 每页展示4个
	    var num = 4;
	    var pageStart = 0,pageEnd = 0;

	    // dropload
	    $('.products_list').dropload({
	        scrollArea : window,
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
                var result = '';
                for(var i = 0; i < 6; i++){
                    result +=   "<li class='products_detail opacity'>"
								+"<a href='##'' class='products_detail_a'>"
									+"<div class='products_detail_img'>"
										+"<img src='../img/shop11.png'>"
									+"</div>"
									+"<div class='products_detail_content'>"
										+"<h3 class='products_name'>菲律宾进口香蕉</h3>"
										+"<p class='detail_description'>新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>"
										+"<p class='price'>￥12.0</p>"
									+"</div>"
								+"</a>"
							+"</li>";
                }
                // 为了测试，延迟1秒加载
                setTimeout(function(){
                    $('.lists').prepend(result);
                    // 每次数据加载完，必须重置
                    me.resetload();
                    // 重置索引值，重新拼接more.json数据
                    counter = 0;
                    // 解锁
                    me.unlock();
                    me.noData(false);
                },1000);
	        },
	        loadDownFn : function(me){
                var result = '';
                counter++;
                pageEnd = num * counter;
                pageStart = pageEnd - num;

                for(var i = pageStart; i < pageEnd; i++){
                    result +=   "<li class='products_detail opacity'>"
								+"<a href='##'' class='products_detail_a'>"
									+"<div class='products_detail_img'>"
										+"<img src='../img/shop11.png'>"
									+"</div>"
									+"<div class='products_detail_content'>"
										+"<h3 class='products_name'>菲律宾进口香蕉</h3>"
										+"<p class='detail_description'>新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>"
										+"<p class='price'>￥12.0</p>"
									+"</div>"
								+"</a>"
							+"</li>";
                    if((i + 1) >= 3){
                        // 锁定
                        me.lock();
                        // 无数据
                        me.noData();
                        break;
                    }
                }
                // 为了测试，延迟1秒加载
                setTimeout(function(){
                    $('.lists').append(result);
                    // 每次数据加载完，必须重置
                    me.resetload();
                },1000);
	        },
	        threshold : 50
	    });
	}
}
var operation = {
	//输入框的基本操作
	search:function(){
		$(".search").keyup(function(){
			var inputText = $(".search").val();
			if (inputText!='') {
				$(".close").show();
			}
			else{
				$(".close").hide();
			}
			$(".close").click(function(){
				$(".search").val('');//清空输入框内容
				$(".close").hide();
			});
			if (event.keyCode == "13") {//keyCode=13是回车键
			 	$('.search_img').click();
			}
			$(".search_img").click(function(){
				// todo 搜索
			});
		});
	},
}
