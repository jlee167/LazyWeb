<!doctype html>

<html>
	<head>
		<link rel="stylesheet" href="css/style.css">		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		
		<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
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
				xhr.open('POST', 'user_register.php', true);
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
	
	<body style="background-image:linear-gradient(blue, white); margin:0; overflow:hidden;">		
		<!-- Top Navigation Bar -->
		<div id="main_nav" style="margin-bottom:0;">
			<nav class="navbar navbar-expand-sm navbar-dark bg-dark mb-4" style="height:100px; margin-bottom:0px !important;">
				<ul class="navbar-nav" style="text-align:center; margin:0 auto; left:20%;">
					<li class="nav-item active"> <a class="nav-link" href="index.html">Home</a></li>
					<li class="nav-item"> <a class="nav-link" href="about.html">LazyBoy</a></li>
					<li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="products.html" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Products</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="#">LTE Camera</a>
							<a class="dropdown-item" href="#">Arduino Camera</a>
						</div>
					</li>
					<li class="nav-item"> <a class="nav-link" href="dashboard.php">Dashboard</a></li>
					<li class="nav-item dropdown"> 
						<a class="nav-link" href="support.php">Support</a>
					</li>
					<li class="nav-item"> <a class="nav-link" href="broadcast.php">Emergency Broadcast </a></li>
				</ul>

				<ul class="navbar-nav">
					<li class="nav-item active" style="font-weight:bold; "> 
							<a id="userInfoUI" class="nav-link" href="#" style="font-weight:bold; text-align:right;"><br></a>
					</li>
				</ul>
					
				<ul class="navbar-nav">
					<li id="signInContainer" class="nav-item active"> 
						<a id="signBtn"class="btn btn-primary" href="login.php" role="button">
							Sign In
						</a>
					</li>					
				</ul>	
			</nav>				
		</div>
			
			
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
		<div id="login">
			<div id="login_manual" style="margin:auto;">
				<form style="width:70%; align:center; margin:auto;">
					<div style="margin:auto; float:center;">
						<input type="text" id="email" name="email" placeholder="Enter your email" style="width:100%; align:center; ">
						<input type="password" id="nickame" name="nickame" placeholder="Choose temporary nickname" style="width:100%; align:center; ">
						<input type="submit" value="Guest Login" style="width:100%; align:center; ">
					</div>
					<div style="width:50%; height:100%; align:center; margin:auto;float:right;">
						
					</div>
				</form>
				
				<table style="width:70%;align:center; margin:auto; margin-top:20px;">
					<tr style="text-align:center; margin:auto;height:50px; display:flex; justify-content:center;"><td style="margin:auto;"><h2>Login</h2></td></tr>
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
											xhttp.open("POST",  "user_register.php", true);
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
					
					<tr style="text-align:center; margin:auto;height:50px; display:flex; justify-content:center;"><td style="margin:auto;">Warning: New users will be automatically registered!</td></tr>
				</table>
			</div>
		</div>
	</body>


<html>