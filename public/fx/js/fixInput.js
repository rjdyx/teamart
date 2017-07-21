$('input, textarea').on('focus', function () {
    if (!navigator.userAgent.match(/Android/i)) {// 修复android
        return
    }
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
    console.log(elementTop)
    console.log(elementBottom)
    $('#form').scrollTop(elementTop)
    // if (bodyh < curTop) {
    //     $('body').scrollTop(curTop)
    // }
}).on('blur', function () {
    if (!navigator.userAgent.match(/Android/i)) {// 修复android
        return
    }
    $('body').scrollTop(0)
})