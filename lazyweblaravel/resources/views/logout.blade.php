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
		<script src="https://apis.google.com/js/platform.js"></script>
	</head>




	<body>
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
			xhr.open('POST', '../server/user_register.php', true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.onload = function() {
				var text = 'Signed in as: ' + xhr.responseText;
				console.log(text);
			};

			xhr.send('GoogleLogin=' + id_token);

			// Todo: Change to something other than user's actual name
			var username = profile.getName();
			var profilePicture = profile.getImageUrl();

			// Set Cookies to access user information from anywhere
			// Todo: Get rid of them accordingly for security
			document.cookie = 'AccessToken=' + id_token + ';';
			document.cookie = 'Authenticator = Google;';
			document.cookie = 'Username = ' + username + ';';
			document.cookie = 'ProfilePicture = ' + profilePicture + ';';
		 }
		</script>

	<div id="googleSignIn" class="customGPlusSignIn">
									<div class="g-signin2" style="height:45px; width:220px; margin-top:10px;" data-onsuccess="onSignIn" data-theme="dark" data-width="400"></div>
							</div>
		<script src="js/cookie_handler.js"></script>
		<script src="js/login_handler.js"></script>
		<script>
			clearCookie();
		</script>

	</body>
</html>
