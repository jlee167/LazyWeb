<!doctype html>

<html>

<head>
    <!-- CSS -->
    @include('includes.imports.styles_common')
    <link rel="stylesheet" href="/css/login.css">

    <!-- OAuth CDN -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
    <script src="https://apis.google.com/js/api:client.js"></script>

    <!-- Page Specific Scripts -->
    @include('includes.imports.csrf')
    <script>
        let redirectUrl = "{{url()->previous()}}";
    </script>

    <script src="{{ mix('js/login.js') }}"></script>
    <script defer src="{{ mix('js/login-oauth-ui.js') }}"> </script>
</head>


<body>

    @include('includes.layouts.navbar')

    <!--Login Information-->
    <div id="view-login">
        <div id="login-manual" class="login-prompt card">
            <form class="login-form">
                <div style="margin:0 auto; float:center;">
                    <p class="login-label">ID</p>
                    <input class="form-control login-form-input" id="input_account" type="text"
                        placeholder="Enter username" aria-describedby="search-btn">

                    <p class="login-label">Password</p>
                    <input class="form-control login-form-input" id="input_password" type="password"
                        placeholder="Enter password" aria-describedby="search-btn">
                    <button id="loginBtn" type="button" class="btn" onclick="nonSocialLogin()"> Login</button>
                </div>
            </form>

            <div style="display:flex; flex-direction:row;">
                <hr class="label-wrapper-line">
                <p style="m-auto">Social Login</p>
                <hr class="label-wrapper-line">
            </div>

            <table id="oAuthSection">
                <tr style="height:50px; display:flex; justify-content:center;">
                    <td style="margin:auto; width:100%;">
                        <a id="kakaoAuthBtn" class="hover-no-effect" href="javascript:loginWithKakao()">
                            <div id="kakaoBtnBackground" class="btn-hover-shadow">
                                <img class="icon" src="{{asset('/images/kakao_icon.png')}}"
                                    style="display:inline-block; width:22px; height:20px;">
                                <span class="buttonText"> Login with Kakao</span>
                            </div>
                        </a>
                        <a href="http://alpha-developers.kakao.com/logout"></a>
                    </td>
                </tr>

                <tr style="text-align:center; margin:auto; margin-top:5px; display:flex; justify-content:center;">
                    <td style="margin:auto; width:100%;">
                        <div id="gSignInWrapper">
                            <div class="btn-hover-shadow" id="googleAuthBtn" class="customGPlusSignIn">
                                <img class="icon" src="https://developers.google.com/identity/images/g-logo.png">
                                <span class="buttonText"> Login with Google</span>
                            </div>
                        </div>
                        <div id="name"></div>
                    </td>
                </tr>
            </table>
            <div
                style="display:flex; flex-direction: row; align-items:center; justify-content:center; margin-bottom: 20px;">
                <p style="vertical-align: middle; margin:0 0 0 0; font-family: 'Nunito Sans', sans-serif;">Not a member
                    yet?</p>
                <a style="vertical-align: middle; margin:0 0 0 10px;" href="/views/register">
                    <b style="color:blue; font-family: 'Nunito Sans', sans-serif;">Sign up now!</b>
                </a>
            </div>
        </div>
    </div>

    @include('includes.layouts.footer')
</body>
<html>
