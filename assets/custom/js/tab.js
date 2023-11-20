$(document).ready(function() {
    let tab = localStorage.getItem('tab');
    if (tab == null) {
        localStorage.setItem('tab','drivers');
    }
})