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


/*
    Text-processing cookie into
*/

/*
function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
	var c = ca[i];
	while (c.charAt(0) == ' ') {
	  c = c.substring(1);
	}
	if (c.indexOf(name) == 0) {
	  return c.substring(name.length, c.length);
	}
  }
  return "";
}
*/

function getCookie(key) {
    cookies = decodeURIComponent(document.cookie).split(';');

    for (var i = 0; i < cookies.length; i++) {
        cookie_item = cookies[i].trim();
        if (cookie_item.includes(String(key))){
            result = cookie_item.split(String(key)).trim();
        }
    }
    return '';
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

	// Refresh
	location.reload();
}
