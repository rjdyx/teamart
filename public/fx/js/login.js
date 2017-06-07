/**
 * Created by rouzh on 2017-4-27.
 */
$('.add-name,.add-password').hide();
$('.myName,.password').on('click',function () {
    $('.add-name,.add-password').hide();
})
$('.button').on('click',function() {
    var name = $(".myName").val();
    var password = $(".password").val();
    if(name==''){
        $('.add-name').css({'display':'inline-block'})
        $('.add-name').css({'color':'red'});
    }
    else if(password==''){
        $('.add-password').css({'display':'inline-block'})
        $('.add-password').css({'color':'red'});
    }
})
$('.radio_left_box').click(function(){
    $(this).addClass("radio_selected");
    $('.radio_right_box').removeClass('radio_selected');
    $('.radio_left').attr('checked',true);
    $('.radio_right').attr('checked',false);
});
$('.radio_right_box').click(function(){
    $(this).addClass("radio_selected");
    $('.radio_left_box').removeClass('radio_selected');
    $('.radio_right').attr('checked',true);
    $('.radio_left').attr('checked',false);
});