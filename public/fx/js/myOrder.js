$(document).ready(function () {
    $(".lis").css("border-bottom", "2px solid #f67357");
    $(".li").css("border-bottom", "2px solid white");
    // $(".myOrder_navigation_bar li").first().addClass("box-sizing","border-box");
    $(".myOrder_navigation_bar li").click(function () {
        $(this).css("border-bottom", "2px solid #f67357");
        $(this).siblings().css("border-bottom", "2px solid white");
    });
    $(".myOrder_navigation_bar_li").eq(0).click();
    //$(".hmyOrder_navigation_bar li").mouseover(function(){
    //    $(this).css("border-bottom","2px solid #f67357");
    //    $(this).siblings().css("border-bottom","none");
    //});
})
data = [];
function fetchALL()
{
    var array =[{
        shop_name:'绿茶宝塔镇河妖1',
    },{
        shop_name:'绿茶宝塔镇河妖2',
    }];
    this.data = array;
}
function fetchPay() {
    var array =[{
        shop_name:'绿茶宝塔镇河妖11',
    },{
        shop_name:'绿茶宝塔镇河妖22',
    },{
        shop_name:'待付款的页面来的',

    }];
    this.data = array;
    
}
function fetchShipment() {
    var array =[{
        shop_name:'绿茶宝塔镇河妖111',
    },{
        shop_name:'绿茶宝塔镇河妖222',
    }];
    this.data = array;

}
function fetchDeliver() {
    var array =[{
        shop_name:'绿茶宝塔镇河妖111',
    },{
        shop_name:'绿茶宝塔镇河妖222',
    }];
    this.data = array;

}
function fetchReceive() {
    var array =[{
        shop_name:'绿茶宝塔镇河妖1111',
    },{
        shop_name:'绿茶宝塔镇河妖2222',
    }];
    this.data = array;

}
function fetchEvaluate() {
    var array =[{
        shop_name:'绿茶宝塔镇河妖11222',
    },{
        shop_name:'绿茶宝塔镇河妖22333',
    }];
    this.data = array;

}
function render()
{   console.log('hello');
        $('#content').empty();
        this.data.map(function(item, index){
            $('#content').append(
            '<div style="position: relative;width: 100%;height: 200px;margin-bottom: 10px;background-color: white;">\
                <div class="myOrder_headline" style="width: 100%;height: 40px;">\
                <img src="../img/shop_sign.png" class="shop_sign">\
                <div class="shop_name">'+item.shop_name+'</div>\
                <img src="../img/right_arrow.png" class="right_sign">\
                <span class="order_state">等待买家付款</span>\
                </div>\
                <div class="order_detail">\
                <img src="../img/shop_photo1.png" class="shop_photo">\
                <div style="float: left;margin-left:10px;margin-top:7px;">\
                <p style="font-size: 12px;color:black;" class="good_name">菲律宾进口香蕉</p>\
                <p class="good_detail">新鲜梨酥雪梨发货供货的供货皇冠分隔符梨</p>\
                </div>\
                <div class="good_price">\
                <p class="new_price">&yen212.00</p>\
            <p class="old_price">&yen299.00</p>\
            <p class="good_num">&times2</p>\
                </div>\
                </div>\
                <div class="total" style="border-bottom: 1px solid #EEEFF1;width: 100%;">\
                <div class="total_word">总2件商品 合计：<span style="color: red;">&yen424.00</span> (包运费)\
            </div>\
            </div>\
                <div>\
                <button href="#" class="bottom_sign"><span class="bottom_word">付款</span></button>\
                <button href="#" class="bottom_sign"><span class="bottom_word">取消订单</span></button>\
                <button href="#" class="bottom_sign"><span class="bottom_word">联系卖家</span></button>\
                </div>\
                </div>'
            );
        });

}
function handleClick(number)
{
    switch (number) {
        case 0: console.log("click");fetchALL();render();break;
        case 1: console.log("click");fetchPay();render();break;
        case 2: console.log("click");fetchShipment();render();break;
        case 3: console.log("click");fetchDeliver();render();break;
        case 4: console.log("click");fetchReceive();render();break;
        case 5: console.log("click");fetchEvaluate();render();break;
    }
}
