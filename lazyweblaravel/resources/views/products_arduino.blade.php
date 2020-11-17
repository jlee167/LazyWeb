<!doctype html>

<html>
	<head>
        @include('includes.imports.styles_common')
	</head>

	<body>
		@include('includes.layouts.navbar')

		<script src="js/auth_handler.js"></script>
		<script>
			var authenticator = getCookie('Authenticator' );
			var username = getCookie('Username' );
			var profilePicture = getCookie('ProfilePicture' );
			var signInContainer = document.getElementById("signInContainer");
			var userProfileUI = document.getElementById("userInfoUI");
			updateLoginUI(authenticator, username, signInContainer, userProfileUI, profilePicture);
		</script>
        @include('includes.layouts.footer')
	</body>
</html>
