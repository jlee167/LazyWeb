<!doctype html>

<html style="height:100%;">

<head>
    <!-- Login -->
    @include('includes.imports.styles_common')
    <link rel="stylesheet" href="/css/login.css">

    <!--  Kakao Imports -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
    <script src="https://apis.google.com/js/api:client.js"></script>

    <script>
        var googleUser = {};
        var startApp = function() {
        gapi.load('auth2', function(){
            // Retrieve the singleton for the GoogleAuth library and set up the client.
            auth2 = gapi.auth2.init({
            client_id: '1083086831094-qatr04h8rnthlm9501q2oa45mjkjh4r0.apps.googleusercontent.com',
            cookiepolicy: 'single_host_origin',
            // Request scopes in addition to 'profile' and 'email'
            //scope: 'additional_scope'
            });
            attachSignin(document.getElementById('customBtn'));
        });
        };

        function attachSignin(element) {
        console.log(element.id);
        auth2.attachClickHandler(element, {},
            function(googleUser) {
                document.getElementById('name').innerText = "Signed in: " +
                    googleUser.getBasicProfile().getName();
                register('Google', googleUser.getAuthResponse().id_token);
            }, function(error) {
                alert(JSON.stringify(error, undefined, 2));
            });
        }
    </script>
    <style type="text/css">
        #customBtn {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            background: white;
            color: #444;
            width: 100%;
            height: 40px;
            border-radius: 5px;
            border: thin solid rgb(180, 178, 178);
            white-space: nowrap;
        }

        #customBtn:hover {
            cursor: pointer;
        }

        span.label {
            font-family: serif;
            font-weight: normal;
        }

        img.icon {
            display: inline-block;
            width: 17px;
            height: 17px;
        }

        span.buttonText {
            display: inline-block;
            vertical-align: middle;
            padding-left: 10px;
            font-size: 14px;
            color: black;
            /* Use the Roboto font that is loaded in the <head> */
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>


<body>

    @include('includes.layouts.navbar')

    <!--Login Information-->
    <div id="view-login">
        <div class="card" style="
            width:          400px;
            border-radius:  1%;
            overflow:       hidden;
            margin-left:    0px;
            margin-right:   0px;
            margin-top:     200px;
            margin-bottom:  200px;
            padding-left:   30px;
            padding-right:  30px;
            height:700px !important;">
            <form class="login-form">
                <div style="margin:0 auto; float:center;">
                    <p style="font-weight:600; font-family: 'Nunito Sans', sans-serif; margin-bottom:7px;">ID</p>
                    <input class="form-control" id="input_account" type="text" placeholder="Enter username"
                        aria-describedby="search-btn" style="width:100%; height:50px;
                                align:center; margin-bottom:20px;">

                    <p style="font-weight:600; font-family: 'Nunito Sans', sans-serif; margin-bottom:7px;">Email</p>
                    <input class="form-control" id="input_email" type="text" placeholder="TBD!"
                        aria-describedby="search-btn" style="width:100%; height:50px;
                                align:center; margin-bottom:20px;" disabled>

                    <p style="font-weight:600; font-family: 'Nunito Sans', sans-serif; margin-bottom:7px;">Password</p>
                    <input class="form-control" id="input_password" type="password" placeholder="Enter password"
                        aria-describedby="search-btn"
                        style="width:100%; height:50px; align:center; margin-bottom:20px;">
                    <p style="font-weight:600; font-family: 'Nunito Sans', sans-serif; margin-bottom:7px;">Confirm
                        Password</p>
                    <input class="form-control" id="confirm_password" type="password" placeholder="Confirm password"
                        aria-describedby="search-btn"
                        style="width:100%; height:50px; align:center; margin-bottom:20px;">
                    <button type="button" class="btn"
                        style="background-color:#e2be1e; color: white; width:100%; height:50px; margin-top:10px;
                                                                font-weight:600; font-family: 'Nunito Sans', sans-serif;" onclick="register('None', null)">
                        Register
                    </button>
                        <a class="hover-no-effect" id="kakao-login-btn" href="javascript:loginWithKakao()">
                            <div class="btn-hover-shadow" style="display:flex; justify-content:center; align-items:center; width:100%;height:40px; border-radius:5px;
                                    margin-top:10px;
                                    background-color:#FEE500;">
                                <img class="icon" src="{{asset('/images/kakao_icon.png')}}"
                                    style="display:inline-block; width:22px; height:20px;">
                                <span class="buttonText" style="display:inline-block;">Register with Kakao</span>
                            </div>
                        </a>

                        <div id="gSignInWrapper" style="margin-top:10px;">
                            <div class="btn-hover-shadow" id="customBtn" class="customGPlusSignIn">
                                <img class="icon" src="https://developers.google.com/identity/images/g-logo.png">
                                <span class="buttonText"> Register with Google</span>
                            </div>
                        </div>
                        <div id="name"></div>
                        <script>
                            startApp();
                        </script>

                </div>
            </form>
        </div>
    </div>

    @include('includes.layouts.footer')
    @include('includes.layouts.modal')




    <script src="/js/auth.js" type="text/javascript"></script>
    <script>
        /* -------------------------------------------------------------------------- */
        /*                           OAuth Modules Initialized                        */
        /* -------------------------------------------------------------------------- */



        /* ---------------------------- Kakao Oauth Setup ---------------------------- */

            /* Set JavaScript Key of current app */
            Kakao.init('fcbc674142c20da29ab5dfe6d1aae93f');
            function loginWithKakao() {
                Kakao.Auth.login({
                success: function(authObj) {
                    var token_kakao = Kakao.Auth.getAccessToken();
                    console.log(token_kakao);
                    register('Kakao', token_kakao);
                },
                fail: function(err) {
                    alert(JSON.stringify(err))
                },
                })
            }

            function getCookie(name) {
                const value = "; " + document.cookie;
                const parts = value.split("; " + name + "=");
                if (parts.length === 2) return parts.pop().split(";").shift();
            }



        /* ---------------------------- Google OAuth Setup --------------------------- */


        /* -------------------------------------------------------------------------- */
        /*                           /OAuth Modules Initialized                       */
        /* -------------------------------------------------------------------------- */






        /* -------------------------------------------------------------------------- */
        /*                           Registration Functions                           */
        /* -------------------------------------------------------------------------- */

        var csrf = "{{ csrf_token() }}";
        let user = null;

        function getRegInfo(){
            user = new Object();
            user.username    = document.getElementById('input_account').value;
            user.password    = document.getElementById('input_password').value;
            user.email       = document.getElementById('input_email').value;
            if (user.username.length == 0) {
                window.alert('Please enter username')
                return false;
            }
            if (user.password.length == 0){
                window.alert('Please enter password')
                return false;
            }

            return true;
        }


        function isPasswordValid(){
            if (user.password !== document.getElementById('confirm_password').value)
                return false;
            else
                return true;
        }


        function cleanup(){
            user = null;
        };


        function register(auth_provider, accessToken){
            if (!getRegInfo())
                return;

            if (!isPasswordValid()) {
                cleanup();
                window.alert("Password mismatch! Check your password inputs.");
                return;
            }
            switch (auth_provider){
                case 'Kakao':
                    break;
                case 'Google':
                    break;
                case 'None':
                    break;
                default:
                    window.alert("Internal Javascript Error: Invalid 'auth_provider'");
                    cleanup();
                    return;
            }

            user.auth_provider = auth_provider;
            user.accessToken = accessToken;
            console.log(user);
            sendRegisterRequest(csrf, user, "{{url()->previous()}}");
        }

        /* -------------------------------------------------------------------------- */
        /*                          /Registration Functions                           */
        /* -------------------------------------------------------------------------- */


    </script>
</body>
<html>
