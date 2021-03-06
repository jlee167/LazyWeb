function updateLoginUI(authenticator, username, signInContainer, userProfileUI, profilePicture) {
	if ((authenticator == "") || (username == "")) {		
		signInContainer.innerHTML = '<a id="signBtn"class="btn btn-primary" href="login.php" role="button">Sign In</a>';
	}
	
	else {
		signInContainer.className = 'nav-item dropdown';
		signInContainer.innerHTML = '<a class="nav-link dropdown-toggle" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="' + profilePicture + '" height="50px" width="50px"> </img></a>' + '<div class="dropdown-menu" aria-labelledby="navbarDropdown"><a class="dropdown-item" href="login.php"">Sign Out</a></div>';
		userProfileUI.innerHTML = username + '<br>' + '(' + authenticator +')';
	}	
}

function clearCookie() {
	
	// Clear cookie
	document.cookie = 'AccessToken=;';
	document.cookie = 'Authenticator =;';
	document.cookie = 'Username = ;';
	document.cookie = 'ProfilePicture = ;';
	
	// Sign out of Google
	if (getCookie('Authenticator' ) == 'Google')
		gapi.auth2.getAuthInstance().signOut();
	

	// Confirm if cookies are cleared
	console.log(document.cookie);
	
	// REfresh
	location.reload();
}

