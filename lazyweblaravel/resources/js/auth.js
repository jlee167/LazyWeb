/* ----------------------------- Login / Logout ----------------------------- */

/**
 *
 * @param {String} csrf
 * @param {String} accessToken
 * @param {String} provider
 * @param {String} redirectUrl
 */
window.authWithOauth2 = function (csrf, accessToken, provider, redirectUrl) {
    let authUri = '/auth/' + provider;

    fetch(authUri, {
        method: 'post',

        body: JSON.stringify({
            "accessToken": accessToken
        }),

        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf
        }
    })

    .then(response => {
        if (response.status === 200){
            return response.json();
        }
    })
    .then(jsonData => {
        if (jsonData.authenticated == true){
            window.location.href = redirectUrl;
        } else {
            window.alert(jsonData.error);
        }
    })
    .catch(err => {
        console.error(err);
    })
}



/**
 * Login with username and password
 *
 * @param {String} csrf
 * @param {String} username
 * @param {String} password
 */
window.authWithUname = function (csrf, username, password, redirectUrl) {

    fetch('/auth', {
        method: 'post',

        body: JSON.stringify({
            "username": username,
            "password": password
        }),

        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf
        }
    })

    .then(response => {
        if (response.status === 200){
            return response.json();
        }
    })
    .then(jsonData => {
        if (jsonData.authenticated == true){
            window.location.href = redirectUrl;
        } else {
            window.alert(jsonData.error);
        }
    })
    .catch(err => {
        console.error(err);
    })
}




/**
 * Logout
 *
 * @param {String} username
 * @param {String} password
 */
window.logout = function () {

    let config = {
        method: 'post',

        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf
        }
    };


    fetch('/logout', config)
    .then(response => {
        if (response.status === 200){
            return response.json();
        } else {
            window.alert("Logout Failed!");
        }
    })
    .then(jsonData => {
        window.location.reload();
        //@Todo: Some logout verification message...
    })
    .catch(err => {
        console.error(err);
    })
}



/* ------------------------------ Registration ------------------------------ */

/**
 * Send user registration request to the server.
 *
 * @param {String} csrf
 * @param {String} userInfo
 * @param {String} redirectUrl
 */
window.sendRegisterRequest = function (userInfo, redirectUrl) {

    let authUri = '/members/' + userInfo.username;
    let config = {
        method: 'post',

        body: JSON.stringify(userInfo),

        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf
        }
    };


    fetch(authUri, config)
    .then(response => {
        if (response.status === 200){
            return response.json();
        } else {
            window.alert("Registration Failed! Response Code: " + String(response.status));
        }
    })
    .then(jsonData => {
        if (jsonData.registered == true) {
            //window.alert("Successfully registered user!");
            window.location.href = '/email/verify';
        } else {
            window.alert(jsonData.error);
        }
    })
    .catch(err => {
        console.error(err);
    })
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
