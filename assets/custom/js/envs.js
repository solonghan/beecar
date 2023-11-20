let baseUrl = 'https://www.anbon.vip/beecar/';
// let baseUrl = 'https://honeybeezdispatch.com/';


// let baseUrl = 'http://localhost/beecar/';
let localUrl = 'https://localhost/bee/';

window.addEventListener('resize', function(event) {
    const windowHeight = $(this).height()
    if (windowHeight <= 600) {
        $('.form-button-group').css('position','static')
    } else {
        $('.form-button-group').css('position','fixed')
    }
}, true);