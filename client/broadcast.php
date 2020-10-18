<!doctype html>

<html>
	<head>
		<!-- Import Custom stylesheets -->
		<link rel="stylesheet" href="css/style.css">		
		<!-- Import Bootstrap CDN -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

		<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		
		<meta charset="utf-8">
		
		<link href="https://unpkg.com/video.js/dist/video-js.css" rel="stylesheet">
		<script src="https://unpkg.com/video.js/dist/video.js"></script>
		<script src="https://unpkg.com/videojs-contrib-hls/dist/videojs-contrib-hls.js"></script>
		<script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?clientId=YOUR_CLIENT_ID"></script>
		
		<!-- Google Imports -->
		<meta name="google-signin-scope" content="profile email">
		<meta name="google-signin-client_id" content="1083086831094-qatr04h8rnthlm9501q2oa45mjkjh4r0.apps.googleusercontent.com">
		<script src="https://apis.google.com/js/platform.js" async defer></script>
		
		<!--  Kakao Imports -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	
	
	<body>	
		<!-- Top Navigation Bar -->
		<div id="main_nav" style="">
			<nav class="navbar navbar-expand-sm navbar-dark bg-dark mb-4 fixed-top" style="height:100px; margin-bottom:0px !important;">
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
							<a id="userInfoUI" class="nav-link" href="#" style="font-weight:bold; text-align:right;"></a>
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
			updateLoginUI(authenticator, username, signInContainer, userProfileUI, profilePicture);
		</script>
		</script>	
		
		<script>
			var peerlist;
		
			var xhttp = new XMLHttpRequest();
			xhttp.open('POST', 'user_register.php', true);
			xhttp.setRequestHeader('Content-Type', 'application/json');
			
			var accessToken = getCookie('AccessToken');
			var authenticator = getCookie('Authenticator');
			
			if (accessToken.length == 0)
				window.location.href = 'login.php';
			
			var peerlist_request = {
				"Request" : "Peer List",
				"Access Token" : accessToken,
				"Authenticator" : authenticator
			};	
			
			xhttp.onload = function() {
				var text = 'Peer List Request Response: ' + xhttp.responseText;
				console.log(text);
				peerlist = JSON.parse(xhttp.responseText);
				console.log(peerlist);
				console.log(peerlist.protectees.length);
				update_table();
			};
			
			console.log(JSON.stringify(peerlist_request));	
			xhttp.send(JSON.stringify(peerlist_request));
			
			function update_table() {				
				let peerlist_content = document.getElementById("peer table");
				let emg_light;
				
				if (peerlist.protectees.length) {					
					for (var i = 0; i < peerlist.protectees.length; i = i + 1) {
						console.log(i);
						if (peerlist.protectees[i]['status'])
							emg_light = '<td style="width:50px; background-color:red;">EMG Light</td></tr>';
						else
							emg_light = '<td style="width:50px; background-color:green;">EMG Light</td></tr>';
						
						peerlist_content.innerHTML += '<tr style="width:100%; height:50px;" onclick=""><td style="width:50px;">' + '<img style="width:50px; height:50px;" src ="' +  peerlist.protectees[i]['id_profile_picture'] + '">' + '</td><td>'
																	+ peerlist.protectees[i]['name']  + '<br>' 
																	+ peerlist.protectees[i]['phone'] +'</td>' + emg_light;
					}			
				}
			}
			
			
		</script>
		
		
		<div id="main-contents" style="overflow:hidden; width:100%; padding-top:100px;">
			<div style="overflow:hidden; min-width:200px; width:20%; position:fixed;background-color:#f5f3f3; height:100%;">		
				<table id="peer table" style="width:100%; height:50px;">

						
				</table>
			</div>	
			
			<!-- Company Info-->			
			<div class="contents" style="min-width:50%; max-width:80%; float:right;">
				<!--div style="min-width:200px; width:50%; margin:auto; position:absolute; left:10%;">
					<video id="emergency_broadcast" class="video-js vjs-default-skin" controls preload="auto" width="600" height="400" data-setup='{}'></video>
				</div>
				<div style="min-width:200px; width:50%; margin:auto; float:right; display:flex; justify-content:center;">
					<div id="map" style="width:70%;height:480px;"></div>
				</div-->
				
				<table style="width:50%; float:right;">
					<tr style="min-width:200px; width:50%; margin-bottom:30px; padding-bottom:30px;">
						<td style="display:flex; justify-content:center;">
							<video id="emergency_broadcast" class="video-js vjs-default-skin" controls preload="auto" width="600" height="400" data-setup='{}'></video>
						</td>
					</tr>
					
					<tr style="min-width:200px; width:50%;  padding-bottom:30px;">
						<td style="display:flex; justify-content:center;">
							<div id="map" style="width:600px;height:400px;"></div>
						</td>
					</tr>
				</table>
				
				<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=fcbc674142c20da29ab5dfe6d1aae93f"></script>
				<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=fcbc674142c20da29ab5dfe6d1aae93f&libraries=services,clusterer,drawing"></script>
				<script>
					var container = document.getElementById('map');
					var lat = 33.450701;
					var streamerPosition = new kakao.maps.LatLng(lat, 126.570667);
					var options = { 
						center: streamerPosition, 
						level: 3 
					};
					var map = new kakao.maps.Map(container, options); 
					
					var marker = new kakao.maps.Marker({
						position: streamerPosition
					});
					marker.setMap(map);	

				</script>

				<script type='text/javascript'>				
					var src_video = '';
					const player = videojs('emergency_broadcast');
				
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
					
					//alert(getCookie('LazyWeb Signature'));
					var authProvider = getCookie('Authenticator');
					
					if (authProvider == 'Kakao') {
						Kakao.init('fcbc674142c20da29ab5dfe6d1aae93f');
						Kakao.API.request({
							url: '/v2/user/me',
							success: function(res) {
								//alert('login success' + JSON.stringify(res));
							},
							fail: function(error) {
								//alert('login success, but failed to request user information: ' + JSON.stringify(error));
							},
						 });		
					}
					else if (authProvider == 'Google') {
						var googleToken = getCookie('AccessToken' );
						var xhp = new XMLHttpRequest();
						xhp.open('POST', 'user_register.php', true);
						xhp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
						
						xhp.onload = function() {
						
							src_video = 'http://www.hlsserver.com/' + xhp.responseText.trim() + '.m3u8';
							console.log(src_video);
							player.src({
								src: src_video,//'http://www.hlsserver.com/0c83f57c786a0b4a39efab23731c7ebc.m3u8',
								type: 'application/x-mpegURL'
							});
						};
						xhp.send("googlestream=" + googleToken);	
					} 
				</script>							
			</div>
		</div>
	</body>
</html>