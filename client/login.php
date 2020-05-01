<!doctype html>

<html>
	<head>
		<link rel="stylesheet" href="css/style.css">		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<!-- Google Imports -->
		<meta name="google-signin-scope" content="profile email">
		<meta name="google-signin-client_id" content="1083086831094-qatr04h8rnthlm9501q2oa45mjkjh4r0.apps.googleusercontent.com">
		<script src="https://apis.google.com/js/platform.js" async defer></script>
		
		<!-- Google Signin Routine -->
		<script>
		var text = '';
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
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.onload = function() {
				var text = 'Signed in as: ' + xhr.responseText;
				console.log(text);
			};
	
			xhr.send('idtoken=' + id_token);
			document.cookie = 'AccessToken=' + id_token + ';';
			document.cookie = 'Authenticator = Google;';		
			console.log(document.cookie);
			
			document.getElementById('signBtn').innerHTML= "Sign Out";
		 }
		</script>
		
		<!--  Kakao Imports -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
	
	</head>
	
	<body style="background-color:#8A2BE2; margin:0; overflow:hidden;">		
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
						<a class="nav-link" href="support.html">Support</a>
					</li>
					<li class="nav-item"> <a class="nav-link" href="broadcast.php">Emergency Broadcast </a></li>
				</ul>
				<ul class="navbar-nav ml-auto">
					<li class="nav-item active"> 
						<a id="signBtn"class="btn btn-primary" href="login.php" role="button">
							Sign In
						</a>
					</li>
				</ul>
			</nav>				
		</div>

		
		<!--Login Information-->
		<div id="login">
			<div id="login_manual" style="margin:auto;">
				<form style="width:50%; align:center; margin:auto;">
					<div style="width:50%; margin:auto; float:left;">
						<input type="text" id="username" name="username" placeholder="Username" style="width:100%; align:center; ">
						<input type="password" id="pwd" name="pwd" placeholder="Password" style="width:100%; align:center; ">
					</div>
					<div style="width:50%; height:100%; align:center; margin:auto;float:right;">
						<input type="submit" value="Login" style="width:100%; align:center; ">
					</div>
				</form>
				
				<table style="align:center; margin:auto;">
					<tr style="text-align:center; margin:auto;"><td>Social Login</td></tr>
					<tr>
						<td>						 
							<!--a href="#"class="btn btn-primary" type="button" style="background-color:yellow; border-color:yellow">
								Login with Kakao
							</a-->
							 
							<a id="kakao-login-btn" style="display:inline-block; width:100%;"></a>
							<a href="http://alpha-developers.kakao.com/logout"></a>
							
								<script type='text/javascript'>
									//<![CDATA[
									// Set JavaScript Key of current app.
									Kakao.init('fcbc674142c20da29ab5dfe6d1aae93f');
									
									// Create Kakao Login button.
									Kakao.Auth.createLoginButton({
										container: '#kakao-login-btn',
										success: function(authObj) {
											alert(JSON.stringify(authObj))
											console.log("Cookie: " + authObj);
											document.cookie += authObj;
											document.cookie = 'LazyWeb Signature = Kakao';
											console.log("Cookie: " + document.cookie);
											
											var token_kakao = Kakao.Auth.getAccessToken();
											console.log(token_kakao);
											var xhttp = new XMLHttpRequest();
											
											xhttp.open("POST",  "user_register.php", true);
											xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
											xhttp.onload = function() {
												var text = 'Signed in as: ' + xhttp.responseText;
												console.log(text);
											};
											xhttp.send("token_kakao="  + token_kakao);		
											document.cookie = 'AccessToken=' + token_kakao + ';';
											document.cookie = 'Authenticator = Kakao;';	
																		
											
											document.getElementById('signBtn').innerHTML= "Sign Out";
											Kakao.API.request({
												url: '/v2/user/me',
												success: function(res) {
													//alert('login success' + JSON.stringify(res));
												},
												fail: function(error) {
													//alert('login success, but failed to request user information: ' + JSON.stringify(error));
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
					<!--tr>
						<td>	
							<a href="#"class="btn btn-primary" type="button" style="background-color:#3B5998; border-color:#3B5998;">
								<i class="fa fa-facebook fa-fw"></i>Login with Facebook
							</a>
						</td>
					</tr-->
					<tr>
						<td>
							<div id="googleSignIn" class="customGPlusSignIn">
									<div class="g-signin2" style="height:45px; width:220px; margin-top:10px;" data-onsuccess="onSignIn" data-theme="dark" data-width="400"></div>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</body>


<html>