<footer class="w-100">
    <ul class="footer_container w-100 pt-10 pb-10">
        <li class="pull-left txt-c">
            <a href="{{url('/')}}" class="block white @if (isset($footer) && $footer == 'home') active @endif">
                <i class="fa fa-home"></i>
                <p class='bottom_content'>首页</p>
            </a>
        </li>
        <li class="pull-left txt-c">
            <a href="{{url('/home/product/list')}}" class="block white @if (isset($footer) && $footer == 'product') active @endif">
                <i class="fa fa-shopping-bag"></i>
                <p class='bottom_content'>商品</p>
            </a>
        </li>
        <li class="pull-left txt-c">
            <a href="{{url('/home/cart')}}" class="block white @if (isset($footer) && $footer == 'cart') active @endif">
                <i class="fa fa-shopping-cart"></i>
                <p class='bottom_content'>购物车</p>
            </a>
        </li>
        <li class="pull-left txt-c">
            <a href="{{url('/home/userinfo')}}" class="block white @if (isset($footer) && $footer == 'user') active @endif">
                <i class="fa fa-user"></i>
                <p class='bottom_content'>我的</p>
            </a>
        </li>
    </ul>
</footer>