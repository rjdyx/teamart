<footer>
    <ul class="footer_container">
        <li>
            <a href="{{url('/')}}" @if (isset($footer) && $footer == 'home') class="active" @endif>
                <i class="fa fa-home"></i>
                <p class='bottom_content'>首页</p>
            </a>
        </li>
        <li>
            <a href="{{url('/home/product/list')}}" @if (isset($footer) && $footer == 'product') class="active" @endif>
                <i class="fa fa-shopping-bag"></i>
                <p class='bottom_content'>商品</p>
            </a>
        </li>
        <li>
            <a href="{{url('/home/cart')}}" @if (isset($footer) && $footer == 'cart') class="active" @endif>
                <i class="fa fa-shopping-cart"></i>
                <p class='bottom_content'>购物车</p>
            </a>
        </li>
        <li>
            <a href="{{url('/home/userinfo')}}" @if (isset($footer) && $footer == 'user') class="active" @endif>
                <i class="fa fa-user"></i>
                <p class='bottom_content'>我的</p>
            </a>
        </li>
    </ul>
</footer>