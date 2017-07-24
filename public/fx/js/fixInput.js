$(function () {
    var windowH = window.innerHeight // 窗口高度
    var isAndroid = navigator.userAgent.match(/Android/i)
    if (isAndroid) {
        alert('android')
        window.addEventListener('resize', function (e) {
            alert('resize')
            var tempH = window.innerHeight
            if (windowH > tempH) {
                // 软键盘出来了
                alert('窗口高度'+windowH)
                alert('当前高度'+tempH)
            } else {
                // 没有软键盘
            }
        })
        $('input, textarea').on('focus', function () {
            alert('focus')
            // var viewTop = $(window).scrollTop(),            // 可视区域顶部
            //     viewBottom = viewTop + window.innerHeight,  // 可视区域底部
            //     elemTop = $(this).offset().top,
            //     elemBottom = elemTop + $(this).height()
            // console.log(viewTop)
            // console.log(viewBottom)
            // console.log(elemTop)
            // console.log(elemHeight)

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
            // $('.login, .register, .reset, .email, .container').css('overflow', 'auto').scrollTop(elementTop)
            $(this)[0].scrollIntoView()
            alert(this)
            alert(elementTop)
            alert(elementBottom)
            // $('.login, .register, .reset, .email, .container').css({'position': 'absolute', 'top': elementTop + 'px', 'left': 0})
        }).on('blur', function () {
            alert('blur')
            // $('.login, .register, .reset, .email, .container').removeAttr('style')
        })
    }
    // $('input, textarea').on('focus', function () {
    //     if (!navigator.userAgent.match(/Android/i)) {// 修复android
    //         return
    //     }
    //     // var viewTop = $(window).scrollTop(),            // 可视区域顶部
    //     //     viewBottom = viewTop + window.innerHeight,  // 可视区域底部
    //     //     elemTop = $(this).offset().top,
    //     //     elemBottom = elemTop + $(this).height()
    //     // console.log(viewTop)
    //     // console.log(viewBottom)
    //     // console.log(elemTop)
    //     // console.log(elemHeight)

    //     /* 获得元素的位置信息 */
    //     var getElementPosition = function(elem) {
    //         var defaultRect = {top: 0, left: 0};
    //         var rect = (elem.getBoundingClientRect && elem.getBoundingClientRect()) || defaultRect;
    //         var ret = {
    //             top: rect.top + document.body.scrollTop,
    //             left: rect.left + document.body.scrollLeft
    //         }
    //         return ret;
    //     }
    //     var elementTop = getElementPosition(this).top, // 元素顶部位置
    //         elementBottom = elementTop + $(this).height() // 元素底部位置
    //     // console.log(elementTop)
    //     // console.log(elementBottom)
    //     $('.login, .register, .reset, .email, .container').css('overflow', 'auto').scrollTop(elementTop)
    // }).on('blur', function () {
    //     if (!navigator.userAgent.match(/Android/i)) {// 修复android
    //         return
    //     }
    //     $('.login, .register, .reset, .email, .container').removeAttr('style' )
    // })
})
