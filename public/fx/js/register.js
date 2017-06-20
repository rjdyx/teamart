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

function loginVali(){
    var result = true;
    if($(".myName").val() == ''){
        $('.add-name').css({'display':'inline-block'})
        $('.add-name').css({'color':'red'});
        result = false;
    }
    if($(".password").val() == ''){
        $('.add-password').css({'display':'inline-block'})
        $('.add-password').css({'color':'red'});
        result = false;
    }
    if($(".password2").val() == ''){
        $('.add-password2').css({'display':'inline-block'})
        $('.add-password2').css({'color':'red'});
        result = false;
    }
    if($(".email").val() == ''){
        $('.add-email').css({'display':'inline-block'})
        $('.add-email').css({'color':'red'});
        result = false;
    }
    if($(".phone").val() == ''){
        $('.add-phone').css({'display':'inline-block'})
        $('.add-phone').css({'color':'red'});
        result = false;
    }
    return result;
};

$('.submit').on('click',function() {
    loginVali();
});