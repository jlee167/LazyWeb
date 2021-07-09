<html>

<head>
    @include('includes.imports.csrf')
    @include('includes.imports.styles_common')
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />

    <style>
        #container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100vw;
        }

        #profilePicture {
            width: 200px;
            height: 200px;
        }

        .label {
            width: 80px;
            text-align: right;
        }

        .content {
            width: 300px;
            overflow: hidden;
        }

        .lsection {
            display: flex;
            flex-direction: row;
            align-items: center;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100px;
        }

        #passwordChange {
            margin-top: 100px;
        }

        .btn-password-submit {
            background-color: rgb(235, 199, 0) !important;
            border-color: rgb(235, 199, 0) !important;
            border-radius: 20px;
            width: 200px;
            color: white;
        }

        #QR-Code {
            margin-top: 20px;
            margin-bottom: 20px;
            width: 100px;
            height: 100px;
        }

        .form-control {
            width: 300px;
        }

        .card {
            width: 400px;
            padding-top: 50px;
            padding-bottom: 50px;
            padding-left: 10px;
            padding-right: 10px;
        }

        pre {
            white-space: pre-wrap;
        }
    </style>
</head>




<body style="overflow-x:hidden;">
    @include('includes.layouts.navbar')

    <div id="container" class="section-contents">
        <article class="card d-flex flex-column align-items-center mt-5">
            <img id="profilePicture" />
            <div class="d-flex flex-row mt-3">
                <div>
                    <section class="form-group">
                        <small class="form-text text-muted">ID#</small>
                        <input id="userID" class="form-control" disabled />
                    </section>

                    <section class="form-group">
                        <small class="form-text text-muted">Username</small>
                        <input id="username" class="form-control" />
                    </section>

                    <section class="form-group">
                        <small class="form-text text-muted">Email</small>
                        <input id="email" class="form-control" disabled />
                    </section>

                    <section class="form-group">
                        <small class="form-text text-muted">OAuth Provider</small>
                        <input id="oauthProvider" class="form-control" disabled />
                    </section>

                    <section class="form-group">
                        <small class="form-text text-muted">Cell</small>
                        <input id="username" class="form-control" placeholder="Not Collected in Beta Version"
                            disabled />
                    </section>

                    <section class="form-group">
                        <small class="form-text text-muted">Full Name</small>
                        <input id="email" class="form-control" placeholder="Not Collected in Beta Version" disabled />
                    </section>
                </div>

                <div>

                </div>
            </div>
            <button class="btn btn-password-submit mt-3" type="submit">Change</button>
        </article>

        <article id="passwordChange" class="card mb-5 d-flex flex-column align-items-center">
            <h1> Change Password</h1>
            <div class="form-group mt-3">
                <small class="form-text text-muted">Current Password</small>
                <input id="currentPassword" class="form-control" type="password" />
            </div>
            <div class="form-group">
                <small class="form-text text-muted">New Password</small>
                <input id="newPassword" class="form-control" type="password" />
            </div>
            <div class="form-group">
                <small class="form-text text-muted">Confirm New Password</small>
                <input id="confirmPassword" class="form-control" type="password" />
            </div>

            <button class="btn btn-password-submit" type="submit" onclick="changePassword();">Submit</button>
        </article>

        <article id="passwordChange" class="card mb-5 d-flex flex-column align-items-center">
            <h1> Google OTP</h1>

            <p id="otpDesc" class="mt-2" v-if="isOtpEnabled">
                You currently have an active Google OTP. <br>
                If you've lost it, there is no way to recover it in beta version.
                <u><b>Please delete your account.</b></u>
            </p>

            <div id="QRcodeContainer" class="d-flex flex-column align-items-center" v-if="!isOtpEnabled">
                <img v-if="isQRCodeAvailable" id="QR-Code" />
                <p v-if="isQRCodeAvailable" class="mt-2 text-center">Scan QR Code with Google OTP Application. <br>
                    <a
                        href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=ko&gl=US">
                        Download Here</a>
                </p>

                <p v-if="!isQRCodeAvailable" class="mt-3 text-center">
                    You are not using Google OTP Authentication. <br>
                    Click below button to generate QR Code. <br><br>
                    Please have your Google OTP App ready. <br>
                    <a
                        href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=ko&gl=US">
                        Download Here</a>
                </p>
                <button v-if="!isQRCodeAvailable" class="btn btn-password-submit" type="submit">Request QR Code</button>
            </div>
        </article>


        <article id="passwordChange" class="card mb-5 d-flex flex-column align-items-center">
            <h1> Delete my account</h1>
            <p class="mt-3 text-center">Records are immediately deleted from database in Beta version.
                Your record will not be kept. You can even make another account with same username.
            </p>
            <button id="deleteBtn" class="btn btn-password-submit mt-2" type="submit"
                onclick="deleteUser();">Goodbye!!!</button>
        </article>
    </div>


    @include('includes.layouts.footer')
</body>


<script>
    const URI_MYINFO = '/self'
    const URI_USER = '/members';
    const URI_CHANGE_PASSWORD = '/members/password';
    const URI_REQUEST_2FA_CODE = '/members/2fa-key';

    let isOtpEnabled = false;
    let isQRCodeAvailable = false;

    /* --------------------------------- Vue App -------------------------------- */
    let app = new Vue({
        el: '#container',
        data: {
            isOtpEnabled: isOtpEnabled,
            isQRCodeAvailable: isQRCodeAvailable
        }
    });


    /* -------------------------------- API Calls ------------------------------- */

    function changePassword() {
        fetch(URI_CHANGE_PASSWORD, {
            method: 'put',

            body: JSON.stringify({
                "currentPassword": String(document.getElementById('currentPassword').value).trim(),
                "newPassword": String(document.getElementById('newPassword').value).trim(),
                "confirmPassword": String(document.getElementById('confirmPassword').value).trim(),
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
            if (jsonData.result == true){
                window.alert("Password Changed. Please login again.");
                window.location.href = '/views/login';
            } else {
                window.alert(jsonData.error);
            }
        })
        .catch(err => {
            console.error(err);
        })
    }



    function deleteUser() {
        fetch(URI_USER, {
            method: 'delete',

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
            if (jsonData.result == true){
                window.location.href = '/views/main';
            } else {
                window.alert(jsonData.error);
            }
        })
        .catch(err => {
            console.error(err);
        });
    }


    /* -------------- Page start up routine: fetch user information ------------- */
    fetch(URI_MYINFO, {
        method: 'get',

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
        document.getElementById('userID').value = jsonData.id;
        document.getElementById('username').value = jsonData.username;
        document.getElementById('email').value = jsonData.email;
        document.getElementById('oauthProvider').value = jsonData.auth_provider;
        isOtpEnabled = jsonData.is2FAenabled;
    })
    .catch(err => {
        console.error(err);
    });
</script>

</html>
