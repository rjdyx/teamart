$(function () {
    // 显示图片弹窗
    $('.J_show_imgs').on('click', function () {
        if ($(this).data('imgs')) {
            var imgs = $(this).data('imgs').split(',')
            $('.show_img').data('imgs', imgs)
            $('.show_img').data('idx', 0)
            $('.show_img').find('img').attr('src', 'http://' + window.location.host + '/' + imgs[0])
            $('.show_box').show()
        }
    })
    // 隐藏图片弹窗
    $('.J_hide_imgs').on('click', function () {
        $('.show_img').data('imgs', '')
        $('.show_img').data('idx', 0)
        $('.show_img').find('img').attr('src', '')
        $('.show_box').hide()
    })
    // 左切换
    $('.J_left').on('click', function () {
        console.log($(this).parent().data('imgs'))
        console.log($(this).parent().data('idx'))
        var imgs = $(this).parent().data('imgs')
        var idx = $(this).parent().data('idx')
        if (idx == 0) {
            $('.show_img').data('idx', imgs.length-1)
            $('.show_img').find('img').attr('src', 'http://' + window.location.host + '/' + imgs[imgs.length-1])
        } else {
            $('.show_img').data('idx', idx-1)
            $('.show_img').find('img').attr('src', 'http://' + window.location.host + '/' + imgs[idx-1])
        }
    })
    // 右切换
    $('.J_right').on('click', function () {
        var imgs = $(this).parent().data('imgs')
        var idx = $(this).parent().data('idx')
        if (idx == imgs.length-1) {
            $('.show_img').data('idx', 0)
            $('.show_img').find('img').attr('src', 'http://' + window.location.host + '/' + imgs[0])
        } else {
            $('.show_img').data('idx', idx+1)
            $('.show_img').find('img').attr('src', 'http://' + window.location.host + '/' + imgs[idx+1])
        }
    })
})