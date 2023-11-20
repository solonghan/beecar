$('input[type="submit"]').on('click', function(e) {
    e.preventDefault();
    let password = $('input[name="password"]').val().trim();
    let confirm_password = $('input[name="confirm_password"]').val().trim();
    if (password !== confirm_password) {
        alert('密碼不一致');
        return
    } else {
        localStorage.setItem('password', JSON.stringify(password))
        location.href = "set-name"
    }
})