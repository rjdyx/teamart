/**
 * Created by rouzh on 2017-4-27.
 */
$('.add-name,.add-password').hide();
$('.myName,.password').on('click',function () {
    $('.add-name,.add-password').hide();
})
function loginVali(){
    var name = $(".myName").val();
    var password = $(".password").val();
    var result = true;
    if(name==''){
        $('.add-name').css({'display':'inline-block'})
        $('.add-name').css({'color':'red'});
        result = false;
    }
    if(password==''){
        $('.add-password').css({'display':'inline-block'})
        $('.add-password').css({'color':'red'});
        result = false;
    }
    return result;
};

$('.submit').on('click',function() {
    loginVali();
});

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