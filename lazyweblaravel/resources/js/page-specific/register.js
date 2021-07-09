const validator = require('validator');

/* ------------------------- Registration Functions ------------------------- */

const ERR_USERNAME_EMPTY = "Please enter username";
const ERR_PASSWORD_EMPTY = "Please enter password";
const ERR_EMAIL_INVALID = "Invalid email. Please check your email format!";
const ERR_CONFIRM_EMPTY = "Please confirm password";
const ERR_PASSWORD_MISMATCH = "Password mismatch! Check your password inputs";
const ERR_FIRST_CHAR = "First character of username should be lowercase alphabet";
const ERR_PASSWORD_SHORT = "Password must be at least 8 characters";
const ERR_USERNAME_SHORT = "Username must be at least 8 characters";
const ERR_USERNAME_INVALID = "Username should contain only alphabets and numbers";

const MIN_LEN_USERNAME = 8;
const MIN_LEN_PASSWORD = 8;

function getRegInfo(user) {
    user.username = String(document.getElementById('input_account').value);
    user.password = String(document.getElementById('input_password').value);
    user.email = String(document.getElementById('input_email').value);
    return true;
}

function inputSanityCheck(user) {
    let passwordConfirm = String(document.getElementById('confirm_password').value);


    /* ------------------------- Check Input Validity ------------------------ */
    if (user.username.length == 0) {
        /* Empty Username */
        window.alert(ERR_USERNAME_EMPTY)
        return false;
    }

    if (user.username.length < MIN_LEN_USERNAME) {
        /* Username too short */
        window.alert(ERR_USERNAME_SHORT)
        return false;
    }

    if (user.password.length == 0) {
        /* Empty password */
        window.alert(ERR_PASSWORD_EMPTY);
        return false;
    }

    if (user.password.length < MIN_LEN_PASSWORD) {
        /* Password too short */
        window.alert(ERR_PASSWORD_SHORT);
        return false;
    }

    if (passwordConfirm.length == 0) {
        /* Password confirmation input is empty */
        window.alert(ERR_CONFIRM_EMPTY);
        return false;
    }

    if (user.password !== passwordConfirm) {
        /* Password matches password confirmation input */
        window.alert(ERR_PASSWORD_MISMATCH);
        return false;
    }

    if (!user.username.charAt(0).match(/[a-z]/)) {
        /* First letter should be lowercaes alphabets */
        window.alert(ERR_FIRST_CHAR);
        return false;
    }

    if (user.username.match(/[^a-z^A-Z^0-9]/)) {
        /* Only alphabets and numbers */
        window.alert(ERR_USERNAME_INVALID);
        return false;
    }

    if (!validator.isEmail(user.email)) {
        /* Email Address Validation */
        window.alert(ERR_EMAIL_INVALID);
        return false;
    }

    return true;
}


function cleanup(user) {
    user = null;
}


window.register = function (auth_provider, accessToken) {
    let user = new Object();

    if (!getRegInfo(user)) {
        user = null;
        return;
    }

    if (!inputSanityCheck(user)) {
        cleanup();
        return;
    }

    switch (auth_provider) {
        case 'Kakao':
            break;
        case 'Google':
            break;
        case 'None':
            break;
        default:
            window.alert("Internal Javascript Error: Invalid 'auth_provider'");
            cleanup(user);
            return;
    }

    user.auth_provider = auth_provider;
    user.accessToken = accessToken;
    sendRegisterRequest(user, "/views/login");
}



/* ---------------------------- Google OAuth Setup --------------------------- */
var googleUser = {};
window.startApp = function () {
    gapi.load('auth2', function () {
        // Retrieve the singleton for the GoogleAuth library and set up the client.
        auth2 = gapi.auth2.init({
            client_id: '494240878735-c8eo6b0m0t8fhd8vo2lcj0a9v6ena7bp.apps.googleusercontent.com',
            cookiepolicy: 'single_host_origin',
            // Request scopes in addition to 'profile' and 'email'
            //scope: 'additional_scope'
        });
        attachSignin(document.getElementById('customBtn'));
    });
};

window.attachSignin = function (element) {
    auth2.attachClickHandler(element, {},
        function (googleUser) {
            //document.getElementById('name').innerText = "Signed in: " +
            //    googleUser.getBasicProfile().getName();
            register('Google', googleUser.getAuthResponse().id_token);
        },
        function (error) {
            alert(JSON.stringify(error, undefined, 2));
        });
}


/* ---------------------------- Kakao Oauth Setup ---------------------------- */

/* Set JavaScript Key of current app */
Kakao.init('fcbc674142c20da29ab5dfe6d1aae93f');

window.loginWithKakao = function () {
    Kakao.Auth.login({
        success: function (authObj) {
            var token_kakao = Kakao.Auth.getAccessToken();
            register('Kakao', token_kakao);
        },
        fail: function (err) {
            alert(JSON.stringify(err))
        },
    })
}

window.getCookie = function (name) {
    const value = "; " + document.cookie;
    const parts = value.split("; " + name + "=");
    if (parts.length === 2) return parts.pop().split(";").shift();
}
