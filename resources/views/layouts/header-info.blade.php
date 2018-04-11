<header class="w-100 pt-10 pb-10">
    <div class="header_left white txt-c pull-left header_back J_header_back">返回</div>
    @if(Auth::user())
<!--     <div class="header_right white txt-c pull-right">
        <i>
            <s class="block white">8</s>
        </i>
        <span>消息</span>
    </div>  -->
    @endif
    <div class='header_center txt-c'><h2 class="white">{{$title}}</h2></div>
</header>
