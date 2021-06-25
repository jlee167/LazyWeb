window.kakaoLogin = function(accessToken) {
    authWithOauth2(csrf, accessToken, 'kakao', redirectUrl);
}

window.nonSocialLogin = function() {
    var username = document.getElementById('input_account').value;
    var password = document.getElementById('input_password').value;
    authWithUname(csrf, username, password, redirectUrl);
}

window.googleLogin = function(accessToken) {
    authWithOauth2(csrf, accessToken, 'google', redirectUrl);
}