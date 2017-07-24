$(function () {
    var windowH = window.innerHeight // 窗口高度
    var isAndroid = navigator.userAgent.match(/Android/i)
    if (isAndroid) {
        // var evt = 'onorientationchange' in window ? 'orientationchange' : 'resize'
        // $(window).on(evt, function (w) {
        //     alert(evt)
        //     var tempH = window.innerHeight
        //     if (windowH > tempH) {
        //         // 软键盘出来了
        //         alert('窗口高度'+windowH)
        //         alert('当前高度'+tempH)
        //         $('.login, .register, .reset, .email, .container').css({'overflow': 'auto'})
        //     } else {
        //         // 没有软键盘
        //         $('.login, .register, .reset, .email, .container').removeAttr('style')
        //     }
        // })
        $('input, textarea').on('focus', function () {
            // $('.login, .register, .reset, .email, .container').css({'position': 'absolute', 'top': -(elementTop - 10) + 'px', 'left': 0, 'Zindex': 1})
            // var viewTop = $(window).scrollTop(),            // 可视区域顶部
            //     viewBottom = viewTop + window.innerHeight,  // 可视区域底部
            //     elemTop = $(this).offset().top,
            //     elemBottom = elemTop + $(this).height()
            // console.log(viewTop)
            // console.log(viewBottom)
            // console.log(elemTop)
            // console.log(elemHeight)
            // $(this)[0].scrollIntoView() // 无效

            /* 获得元素的位置信息 */
            var getElementPosition = function(elem) {
                var defaultRect = {top: 0, left: 0};
                var rect = (elem.getBoundingClientRect && elem.getBoundingClientRect()) || defaultRect;
                var ret = {
                    top: rect.top + document.body.scrollTop,
                    left: rect.left + document.body.scrollLeft
                }
                return ret;
            }
            var elementTop = getElementPosition(this).top, // 元素顶部位置
                elementBottom = elementTop + $(this).height() // 元素底部位置
            if (elementBottom > windowH / 2) {
                $('.filling').addClass('active')
            }
        }).on('blur', function () {
            $('.filling').removeClass('active')
            // $('.login, .register, .reset, .email, .container').removeAttr('style')
        })
    }
})
