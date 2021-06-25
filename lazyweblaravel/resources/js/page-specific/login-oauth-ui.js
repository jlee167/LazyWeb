var googleUser = {};


var startApp = function() {
    gapi.load('auth2', function() {
        // Retrieve the singleton for the GoogleAuth library and set up the client.
        auth2 = gapi.auth2.init({
            client_id: '494240878735-c8eo6b0m0t8fhd8vo2lcj0a9v6ena7bp.apps.googleusercontent.com',
            cookiepolicy: 'single_host_origin',
            // Request scopes in addition to 'profile' and 'email'
            // scope: 'additional_scope'
        });
        attachSignin(document.getElementById('googleAuthBtn'));
    });
};


function attachSignin(element) {
    auth2.attachClickHandler(element, {},
        function(googleUser) {
            //document.getElementById('name').innerText = "Signed in: " +
            //    googleUser.getBasicProfile().getName();
            googleLogin(googleUser.getAuthResponse().id_token);
        },
        function(error) {
            alert(JSON.stringify(error, undefined, 2));
        });
}

startApp();



/* Set JavaScript Key of current app */
Kakao.init('fcbc674142c20da29ab5dfe6d1aae93f');

window.loginWithKakao = function() {
    Kakao.Auth.login({
        success: function(authObj) {
            var token_kakao = Kakao.Auth.getAccessToken();
            kakaoLogin(token_kakao);
        },
        fail: function(err) {
            alert(JSON.stringify(err))
        },
    })
}