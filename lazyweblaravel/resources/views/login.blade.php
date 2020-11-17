<!doctype html>

<html style="height:100%;">
	<head>
        @include('includes.imports.styles_common')

		<!-- Google Imports -->
		<meta name="google-signin-scope" content="profile email">
		<meta name="google-signin-client_id" content="1083086831094-qatr04h8rnthlm9501q2oa45mjkjh4r0.apps.googleusercontent.com">
		<script src="https://apis.google.com/js/platform.js" async defer></script>

		<!-- Google Signin Routine -->
		<script>
			var text = '';
			var login_enable;
			 function onSignIn(googleUser) {
				// Useful data for your client-side scripts:
				var profile = googleUser.getBasicProfile();
				console.log("ID: " + profile.getId()); // Don't send this directly to your server!
				console.log('Full Name: ' + profile.getName());
				console.log('Given Name: ' + profile.getGivenName());
				console.log('Family Name: ' + profile.getFamilyName());
				console.log("Image URL: " + profile.getImageUrl());
				console.log("Email: " + profile.getEmail());

				// The ID token you need to pass to your backend:
				var id_token = googleUser.getAuthResponse().id_token;
				console.log("ID Token: " + id_token);
				var xhr = new XMLHttpRequest();
				xhr.open('POST', '../server/user_register.php', true);
				xhr.setRequestHeader('Content-Type', 'application/json');
				xhr.onload = function() {
					var text = 'Signed in as: ' + xhr.responseText;
					console.log(text);
				};

				var registration_request = {
					"Request" : "Registration",
					"Access Token" : id_token,
					"Authenticator" : "Google"
				};

				xhr.send(JSON.stringify(registration_request));

				// Todo: Change to something other than user's actual name
				//console.log(login_enable);
				if (login_enable == true) {
					// Set Cookies to access user information from anywhere
					// Todo: Get rid of them accordingly for security
					var username = profile.getName();
					var profilePicture = profile.getImageUrl();

					document.cookie = 'Access Token=' + id_token + ';';
					document.cookie = 'Authenticator = Google;';
					document.cookie = 'Username = ' + username + ';';
					document.cookie = 'ProfilePicture = ' + profilePicture + ';';
					//console.log(document.cookie);

					//gapi.auth2.getAuthInstance().signOut();
					window.location.href = 'index.html';
				}
				else {
					login_enable = true;
					//clearCookie();
				}
			 }
		</script>

		<!--  Kakao Imports -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>

	</head>

    <body style="margin:0; height:100%; overflow:scroll;">

		@include('includes.layouts.navbar')

		<script src="js/cookie_handler.js"></script>
		<script src="js/login_handler.js"></script>
		<script>
			var authenticator = getCookie('Authenticator' );
			var username = getCookie('Username' );
			var profilePicture = getCookie('ProfilePicture' );
			var signInContainer = document.getElementById("signInContainer");
			var userProfileUI = document.getElementById("userInfoUI");
			if ((authenticator == "Google") | (authenticator == "Kakao"))
				clearCookie();
			updateLoginUI(authenticator, username, signInContainer, userProfileUI, profilePicture);
			login_enable = false;
		</script>

		<!--Login Information-->
		<div class="section-contents-nopadding">
            <div id="view-login">
                <div id="login-manual" class="card w-25 h-50">
                    <form style="align:center; margin:auto; width:75%; background-color:transparent;">
                        <div style="margin:auto; float:center;">
                            <input class="login-normal" type="text" id="email" name="email" placeholder="Enter your email" style="width:100%; align:center;">
                            <input class="login-normal" type="password" id="nickame" name="nickame" placeholder="Choose temporary nickname" style="width:100%; align:center; ">
                            <input type="submit" value="Guest Login" style="width:100%; align:center; ">
                        </div>
                    </form>

                    <table style="width:70%;align:center; margin:auto; background-color:transparent;">
                        <tr style="height:50px; display:flex; justify-content:center;">
                            <td style="margin:auto;">
                                <a id="kakao-login-btn" style=""></a>
                                <a href="http://alpha-developers.kakao.com/logout"></a>

                                    <script type='text/javascript'>
                                        // Set JavaScript Key of current app.
                                        Kakao.init('fcbc674142c20da29ab5dfe6d1aae93f');

                                        // Create Kakao Login button.
                                        Kakao.Auth.createLoginButton({
                                            container: '#kakao-login-btn',
                                            success: function(authObj) {
                                                alert(JSON.stringify(authObj))
                                                console.log("Cookie: " + authObj);
                                                document.cookie += authObj;

                                                var token_kakao = Kakao.Auth.getAccessToken();
                                                var profile = Kakao.Auth.getBasicProfile;


                                                console.log(token_kakao);
                                                var xhttp = new XMLHttpRequest();
                                                xhttp.open("POST",  "../server/user_register.php", true);
                                                xhttp.setRequestHeader('Content-Type', 'application/json');
                                                xhttp.onload = function() {
                                                    var text = 'Signed in as: ' + xhttp.responseText;
                                                    console.log(text);
                                                };
                                                var login_data = {
                                                    "Request" : "Registration",
                                                    "Access Token" : token_kakao,
                                                    "Authenticator" : "Kakao"
                                                };
                                                console.log(JSON.stringify(login_data));

                                                xhttp.send(JSON.stringify(login_data));
                                                document.cookie = 'AccessToken=' + token_kakao + ';';
                                                document.cookie = 'Authenticator = Kakao;';
                                                console.log("Cookie: " + Kakao.Auth.getName);

                                                //document.getElementById('signBtn').innerHTML= "Sign Out";
                                                Kakao.API.request({
                                                    url: '/v2/user/me',
                                                    success: function(res) {
                                                        //response = JSON.parse(res);
                                                        //alert('login success' + JSON.stringify(res));
                                                        //alert(res["properties"]["nickname"]);
                                                        document.cookie = 'Username = ' + res["kakao_account"]["email"] + ';';
                                                        document.cookie = 'ProfilePicture = ' + res["properties"]["thumbnail_image"]  + ';';
                                                        window.location.href = 'index.html';
                                                    },
                                                    fail: function(error) {
                                                        alert('login success, but failed to request user information: ' + JSON.stringify(error));
                                                        return;
                                                    },
                                                });
                                            },
                                            fail: function(err) {
                                                    alert(JSON.stringify(err));
                                            }
                                        });
                                    </script>
                            </td>
                        </tr>

                        <tr style="text-align:center; margin:auto; display:flex; justify-content:center;">
                            <td style="margin:auto;">
                                <div id="googleSignIn" class="customGPlusSignIn"  style="width:100%;">
                                        <div class="g-signin2" style="height:45px; width:220px; margin-top:10px; " data-onsuccess="onSignIn" data-theme="dark" data-width="400"></div>
                                </div>
                            </td>
                        </tr>

                    </table>

                </div>
            </div>
            @include('includes.layouts.footer')
        </div>

	</body>


<html>
