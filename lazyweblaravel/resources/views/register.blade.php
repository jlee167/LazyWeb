<!doctype html>

<html style="height:100%;">

<head>
    <!-- Login -->
    @include('includes.imports.csrf')
    @include('includes.imports.styles_common')
    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="/css/register.css">

    <!--  Kakao Imports -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
    <script src="https://apis.google.com/js/api:client.js"></script>

    <script src="/js/auth.js" type="text/javascript"></script>
    <script src="/js/register.js" type="text/javascript"></script>
</head>


<body>
    @include('includes.layouts.navbar')

    <!--------------------------------- login form --------------------------------->
    <div id="view-login">
        <article class="card register-prompt">
            <form class="login-form">
                <div style="margin:0 auto; float:center;">
                    <div><p class="login-label">ID</p></div>
                    <input class="form-control login-form-input" id="input_account" type="text"
                        placeholder="Enter username" aria-describedby="search-btn">

                    <div><p class="login-label">Email</p></div>
                    <input class="form-control login-form-input" id="input_email" type="text" placeholder="Enter Email"
                        aria-describedby="search-btn">
                    <!--disabled-->

                    <div><p class="login-label">Password</p></div>
                    <input class="form-control login-form-input" id="input_password" type="password"
                        placeholder="Enter password" aria-describedby="search-btn">

                    <div><p class="login-label">Confirm Password</p></div>
                    <input class="form-control login-form-input" id="confirm_password" type="password"
                        placeholder="Confirm password" aria-describedby="search-btn">

                    <button type="button" class="btn btn-register" onclick="javascript:register('None', null)">
                        Register (No SNS Link)
                    </button>


                    <!----------------------------- Kakao Signin Button -------------------------->
                    <a class="hover-no-effect" id="kakao-login-btn" href="javascript:loginWithKakao()">
                        <div class="btn-hover-shadow btn-container-kakao">
                            <img class="icon-kakao" src="{{asset('/images/kakao_icon.png')}}">
                            <span class="buttonText">Register with Kakao</span>
                        </div>
                    </a>


                    <!---------------------------- Google Signin Button -------------------------->
                    <div id="gSignInWrapper" style="margin-top:10px;">
                        <div class="btn-hover-shadow" id="customBtn" class="customGPlusSignIn">
                            <img class="icon-google" src="https://developers.google.com/identity/images/g-logo.png">
                            <span class="buttonText"> Register with Google</span>
                        </div>
                    </div>
                    <div id="name"></div>

                    <div id="progressSpinner">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only"></span>
                        </div>
                        <h6>Registering...</h6>
                        </div>

                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>

                    <script>
                        startApp();
                    </script>

                </div>
            </form>
        </article>
    </div>

    @include('includes.layouts.footer')
</body>


<html>
