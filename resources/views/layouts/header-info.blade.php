<header>
    <div class="header_left pull-left header_back J_header_back">返回</div>
    @if(Auth::user())
<!--     <div class="header_right pull-right">
        <i>
            <s>8</s>
        </i>
        <span>消息</span>
    </div>  -->
    @endif
    <div class='header_center'><h2>{{$title}}</h2></div>
</header>
