(function($){
    let curhref = window.location.href
    $('.sidebar-menu')
    .find('.active').removeClass('active').end()
    .find('a').each(function (idx, elem) {
        let href = $(this).attr('href')
        if (curhref === href) {
            $(this)
                .parent().addClass('active').end()
                .parents('.treeview').addClass('active')
        }
    })
})($)