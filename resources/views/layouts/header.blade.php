<header class="w-100 pt-10 pb-10">
    <div class="header_left white txt-c pull-left J_show_header_category">
        <i></i>
        <span class="block">分类</span>
    </div>
    @if(Auth::user())
    <!-- <div class="header_right white txt-c pull-right">
        <div class="header_kefu relative txt-c">
            <i class="fa fa-headphones fz-20"></i>
            <s class="block white">8</s>
        </div>
        <span class="block">客服</span>
    </div> -->
    @endif
    <div class="header_center w-100 txt-c">
        <i class="fa fa-search header_search fz-16 relative"></i>
        <input type="text" class="header_search_inp J_header_search_inp" placeholder="请输入你搜索的商品" value="{{isset($_GET['name'])?$_GET['name']:''}}">
        <i class="fa fa-arrow-circle-right hide header_close inline-block txt-c fz-16 J_header_search"></i>
    </div>
    <?php 
        $categorys = App\ProductCategory::select('id','name')->get();
    ?>
    <div class="header_category w-100 h-100 J_hide_header_category">
        <ul>
            @foreach($categorys as $category)
            <li class="w-100">
                <a class="chayefont txt-c fz-14 block" href="{{url('/home/product/list')}}?category={{$category->id}}">{{$category->name}}</a>
            </li>
            @endforeach
        </ul>
    </div>
</header>