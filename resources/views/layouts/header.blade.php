<!-- 顶部 -->
<header>
    <div class="header_left pull-left">
        <i></i>
        <span>分类</span>
    </div>
    @if(Auth::user())
    <div class="header_right pull-right">
        <i>
            <s>8</s>
        </i>
        <span>消息</span>
    </div>
    @endif
    <div class="header_center">
        <i class="fa fa-search header_search"></i>
        <input type="text" class="header_search_inp" placeholder="请输入你搜索的商品" style="opacity: 0.6;">
        <i class="fa fa-times-circle header_close hide"></i>
    </div>
    <div class="header_container none"></div>
</header>