$(document).ready(function () {
    const page = sessionStorage.getItem('page');
    $(`.appBottomMenu .${page}`).addClass('active');
    $(window).bind('beforeunload',function() {
        sessionStorage.removeItem('page');
    })
})