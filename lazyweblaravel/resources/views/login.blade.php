<!doctype html>

<html style="height:100%;">
	<head>
        <!-- Login -->
        @include('includes.imports.styles_common')
        <link rel="stylesheet" href="/css/login.css">

        <!--  Kakao Imports -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
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
            width: 300px;
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
            color:black;
            /* Use the Roboto font that is loaded in the <head> */
            font-family: 'Roboto', sans-serif;
        }
        </style>
	</head>




    <body style="margin:0; height:100%; overflow:scroll;">

		@include('includes.layouts.navbar')

		<!--Login Information-->
		<div class="section-contents-nopadding">
            <div id="view-login">
                <div id="login-manual" class="login-prompt card px-md-5 pr-md-5 pb-5 py-5">
                    <form class="login-form" style="align:center; margin:auto; background-color:transparent;">
                        <div style="margin:0 auto; float:center;">
                            <p style="font-weight:600; font-family: 'Nunito Sans', sans-serif; margin-bottom:7px;">ID</p>
                            <input class="form-control" id="input_account" type="text" placeholder="Enter username" aria-describedby="search-btn" style="width:100%; height:50px;
                                    align:center; margin-bottom:20px;">
                            <p style="font-weight:600; font-family: 'Nunito Sans', sans-serif; margin-bottom:7px;">Password</p>
                            <input class="form-control" id="input_password" type="password" placeholder="Enter password" aria-describedby="search-btn" style="width:100%; height:50px;
                                    align:center; margin-bottom:20px;">
                            <button type="button" class="btn" style="background-color:#5603ad; color: white; width:100%; height:50px;
                                                                    font-weight:600; font-family: 'Nunito Sans', sans-serif;"
                                                                    onclick="nonSocialLogin()">
                                                                    Login</button>
                        </div>
                    </form>
                    <hr style="width:80%; margin:auto; margin-top:15px; margin-bottom:15px;">

                    <table style="width:70%;align:center; margin:auto; background-color:transparent;">
                        <tr style="height:50px; display:flex; justify-content:center;">
                            <td style="margin:auto;">
                                <a id="kakao-login-btn" href="javascript:loginWithKakao()"
                                >
                                    <div style="display:flex; justify-content:center; align-items:center; width:300px;height:40px; border-radius:5px;
                                        background-color:#FEE500;">
                                        <img class="icon" src="{{asset('/images/kakao_icon.png')}}"
                                            style="display:inline-block; width:22px; height:20px;"
                                        >
                                        <span class="buttonText" style="display:inline-block;">Login with Kakao</span>
                                    </div>
                                </a>
                                <a href="http://alpha-developers.kakao.com/logout"></a>
                            </td>
                        </tr>

                        <tr style="text-align:center; margin:auto; display:flex; justify-content:center;">
                            <td style="margin:auto;">
                                <!-- In the callback, you would hide the gSignInWrapper element on a
                                successful sign in -->
                                <div id="gSignInWrapper">
                                    <div id="customBtn" class="customGPlusSignIn">
                                        <img class="icon" src="https://developers.google.com/identity/images/g-logo.png">
                                        <span class="buttonText"> Login with Google</span>
                                    </div>
                                </div>
                                <div id="name"></div>
                                <script>
                                    startApp();
                                </script>
                            </td>
                        </tr>
                    </table>

                </div>
            </div>

            @include('includes.layouts.footer')
        </div>




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
                    alert(JSON.stringify(authObj))
                    var token_kakao = Kakao.Auth.getAccessToken();
                    console.log(token_kakao);
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
        /*                            Authentication Functions                        */
        /* -------------------------------------------------------------------------- */


            var csrf = "{{ csrf_token() }}";

            /* ---------------------- Login with Username/Password ---------------------- */
            function nonSocialLogin(){
                var username = document.getElementById('input_account').value;
                var password = document.getElementById('input_password').value;
                authWithUname(csrf, username, password, "{{url()->previous()}}");
            }


            /* ------------------------ Login with Kakao Account ------------------------ */
            function kakaoLogin(accessToken){
                authWithOauth2(csrf, accessToken, 'kakao', "{{url()->previous()}}");
            }


            /* ------------------------ Login with Google Account ----------------------- */
            function googleLogin(accessToken){
                authWithOauth2(csrf, accessToken, 'google', "{{url()->previous()}}");
            }


        /* -------------------------------------------------------------------------- */
        /*                            /Authentication Functions                       */
        /* -------------------------------------------------------------------------- */


        </script>
	</body>
<html>
