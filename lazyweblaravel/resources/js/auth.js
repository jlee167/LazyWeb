/* ----------------------------- Login / Logout ----------------------------- */

/**
 *
 * @param {String} csrf
 * @param {String} accessToken
 * @param {String} provider
 * @param {String} redirectUrl
 */
window.authWithOauth2 = function (csrf, accessToken, provider, redirectUrl) {
    /* Sign in and return to previous url on success. */
    let loginRequest = new XMLHttpRequest();
    var authUri = '/auth/' + provider;
    console.log(accessToken);
    console.log(authUri);

    loginRequest.open('POST', authUri, true);
    loginRequest.setRequestHeader('Content-Type', 'application/json');
    loginRequest.setRequestHeader('X-CSRF-TOKEN', csrf);
    loginRequest.onload = function () {
        console.log(loginRequest.responseText);
        var response = JSON.parse(loginRequest.responseText);
        if (response.authenticated == true) {
            console.log("Successfully authenticated by LazyWeb!");
            window.location.href = redirectUrl;
        } else {
            window.alert(response.error);
        }
    };


    loginRequest.send(JSON.stringify({
        "accessToken": accessToken
    }));
}



/**
 * Login with username and password
 *
 * @param {String} csrf
 * @param {String} username
 * @param {String} password
 */
window.authWithUname = function (csrf, username, password, redirectUrl) {

    /* Sign in and return to previous url on success. */
    let loginRequest = new XMLHttpRequest();
    loginRequest.open('POST', '/auth', true);
    loginRequest.setRequestHeader('Content-Type', 'application/json');
    loginRequest.setRequestHeader('X-CSRF-TOKEN', csrf);
    loginRequest.onload = function () {
        console.log(loginRequest.responseText);
        var response = JSON.parse(loginRequest.responseText);
        if (response.authenticated == true) {
            console.log("Successfully authenticated by LazyWeb!");
            window.location.href = redirectUrl;
        } else {
            window.alert(response.error);
        }
    };

    loginRequest.send(JSON.stringify({
        "username": username,
        "password": password
    }));
}




/**
 * Login with username and password
 *
 * @param {String} csrf
 * @param {String} username
 * @param {String} password
 */
window.logout = function () {
    var csrf = "{{ csrf_token() }}";
    var loginRequest = new XMLHttpRequest();
    loginRequest.open('POST', '/logout', true);
    loginRequest.setRequestHeader('Content-Type', 'application/json');
    loginRequest.setRequestHeader('X-CSRF-TOKEN', csrf);
    loginRequest.onload = function () {
        console.log(loginRequest.responseText);
        var response = JSON.parse(loginRequest.responseText);

        //@Todo: Some logout verification message...

        console.log("Successfully Logged Out!")
        window.location.reload();
    };

    loginRequest.send();
}



/* ------------------------------ Registration ------------------------------ */

/**
 * Send user registration request to the server.
 *
 * @param {String} csrf
 * @param {String} userInfo
 * @param {String} redirectUrl
 */
window.sendRegisterRequest = function (csrf, userInfo, redirectUrl) {
    /* Sign in and return to previous url on success. */
    let registerRequest = new XMLHttpRequest();
    registerRequest.open('POST', '/members/' + userInfo.username, true);
    registerRequest.setRequestHeader('Content-Type', 'application/json');
    registerRequest.setRequestHeader('X-CSRF-TOKEN', csrf);
    registerRequest.onload = function () {
        console.log(registerRequest.responseText);
        var response = JSON.parse(registerRequest.responseText);
        console.log(response);
        if (response.registered == true) {
            window.alert("Successfully registered user!");
            window.location.href = redirectUrl;
        } else {
            window.alert(response.error);
        }
    };
    registerRequest.send(JSON.stringify(userInfo));
}




/* ----------------------------- Cookie Handler ----------------------------- */

/**
 * Returns Cookie specified by key
 *
 * @param {String} key
 */
window.getCookie = function (key) {
    cookies = decodeURIComponent(document.cookie).split(';');

    for (var i = 0; i < cookies.length; i++) {
        cookie_item = cookies[i].trim();
        if (cookie_item.includes(String(key))) {
            result = cookie_item.split(String(key)).trim();
        }
    }
    return result;
}
