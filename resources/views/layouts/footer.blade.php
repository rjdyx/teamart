<!-- 底部 -->
<!-- <div class="bottom">
    <ul class='bottom_container'>
        <li>
            <a href="{{url('/')}}">
                @if ($footer == 'home')
                <img src="{{ url('fx/img/home-b.png') }}" class='home'>
                @else 
                <img src="{{ url('fx/img/home-w.png') }}" class='home'>
                @endif
                <p class='bottom_content' @if($footer == 'home') style="color: #474644;" @endif>首页</p>
            </a>
        </li>
        <li>
            <a href="{{url('/home/product/list')}}">
                @if ($footer == 'product')
                <img src="{{ url('fx/img/product-b.png') }}" class='products_actived'>
                @else 
                <img src="{{ url('fx/img/product-w.png') }}" class='products_actived''>
                @endif
                <p class='bottom_content' @if($footer == 'product') style="color: #474644;" @endif>商品</p>
            </a>
        </li>
        <li>
            <a href="{{url('/home/cart')}}">
                @if ($footer == 'cart')
                <img src="{{ url('fx/img/cart-b.png') }}" class='shoppingCart'>
                @else 
                <img src="{{ url('fx/img/cart-w.png') }}" class='shoppingCart''>
                @endif
                <p class='bottom_content' @if($footer == 'cart') style="color: #474644;" @endif>购物车</p>
            </a>
        </li>
        <li>
            <a href="{{url('/home/userinfo')}}">
                @if ($footer == 'user')
                <img src="{{ url('fx/img/user-b.png') }}" class='bottom_img'>
                @else 
                <img src="{{ url('fx/img/user-w.png') }}" class='bottom_img''>
                @endif
                <p class='bottom_content' @if($footer == 'user') style="color: #474644;" @endif>我的</p>
            </a>
        </li>
    </ul>
</div> -->
<footer class="base-fontsize">
    <ul class="footer_container">
        <li>
            <a href="{{url('/')}}" @if ($footer == 'home') class="active" @endif>
                <!-- <img src="{{ url('fx/img/home-b.png') }}" class='home'>
                <img src="{{ url('fx/img/home-w.png') }}" class='home'> -->
                <i class="fa fa-home"></i>
                <p class='bottom_content'>首页</p>
            </a>
        </li>
        <li>
            <a href="{{url('/home/product/list')}}" @if ($footer == 'product') class="active" @endif>
                <!-- <img src="{{ url('fx/img/product-b.png') }}" class='products_actived'>
                <img src="{{ url('fx/img/product-w.png') }}" class='products_actived''> -->
                <i class="fa fa-shopping-bag"></i>
                <p class='bottom_content'>商品</p>
            </a>
        </li>
        <li>
            <a href="{{url('/home/cart')}}" @if ($footer == 'cart') class="active" @endif>
                <!-- <img src="{{ url('fx/img/cart-b.png') }}" class='shoppingCart'>
                <img src="{{ url('fx/img/cart-w.png') }}" class='shoppingCart''> -->
                <i class="fa fa-shopping-cart"></i>
                <p class='bottom_content'>购物车</p>
            </a>
        </li>
        <li>
            <a href="{{url('/home/userinfo')}}" @if ($footer == 'user') class="active" @endif>
                <!-- <img src="{{ url('fx/img/user-b.png') }}" class='bottom_img'>
                <img src="{{ url('fx/img/user-w.png') }}" class='bottom_img''> -->
                <i class="fa fa-user"></i>
                <p class='bottom_content'>我的</p>
            </a>
        </li>
    </ul>
</footer>