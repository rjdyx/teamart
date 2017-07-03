<header>
    <div class="header_left pull-left J_show_header_category">
        <i></i>
        <span>分类</span>
    </div>
    @if(Auth::user())
<!--     <div class="header_right pull-right">
        <i>
            <s>8</s>
        </i>
        <span>消息</span>
    </div> -->
    @endif
    <div class="header_center">
        <i class="fa fa-search header_search"></i>
        <input type="text" class="header_search_inp J_header_search_inp" placeholder="请输入你搜索的商品" style="opacity: 0.6;">
        <i class="fa fa-hand-o-right header_close hide J_header_search"></i>
    </div>
    <?php 
        $categorys = App\ProductCategory::select('id','name')->get();
    ?>
    <div class="header_category J_hide_header_category">
        <ul>
            @foreach($categorys as $category)
            <li>
                <a href="{{url('/home/product/list')}}?category={{$category->id}}">{{$category->name}}</a>
            </li>
            @endforeach
        </ul>
    </div>
</header>