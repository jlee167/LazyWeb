<!doctype html>

<html>
	<head>
		<!-- Import Bootstrap CDN -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<!-- Import Custom stylesheets -->
		<link rel="stylesheet" href="css/style.css">		
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
		<div class="continer" id="main_nav" style="margin-bottom:0;">
			<nav class="navbar navbar-expand-sm navbar-dark bg-dark mb-4" style="height:70px; margin-bottom:0;">
				<ul class="navbar-nav" style="text-align:center;">
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
					<li class="nav-item"> <a class="nav-link" href="friends.php">Friends </a></li>
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

		<script src="js/cookie_handler.js"></script>
		<script>
				var authProvider = getCookie('LazyWeb Signature');
				if (authProvider) {
					document.getElementById('signBtn').innerHTML = "Sign Out";
				}
		</script>	
			
			
		<h1 style="text-align:center;">Emergency Broadcast</h1>	
		<!-- Company Info-->			
		<div class="contents" style="width:100%; overflow:scroll;">
			
			<div style="width:50%; margin:auto; position:absolute; left:10%;">
				<video id="emergency_broadcast" class="video-js vjs-default-skin" controls preload="auto" width="640" height="480" data-setup='{}'></video>
			</div>
			<div style="width:50%; margin:auto; float:right; display:flex; justify-content:center;">
				<div id="map" style="width:70%;height:480px;"></div>
			</div>
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
				var authProvider = getCookie('LazyWeb Signature');
				
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
					var googleToken = getCookie('GoogleToken' );
					var xhp = new XMLHttpRequest();
					xhp.open('POST', 'user_register.php', true);
					xhp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
					xhp.onload = function() {
					
						src_video = 'http://www.hlsserver.com/' + xhp.responseText.trim() + '.m3u8';
						console.log(src_video);
						player.src({
							src: src_video,//'http://www.hlsserver.com/stream.m3u8',
							type: 'application/x-mpegURL'
						});
					};
					xhp.send("googlestream=" + googleToken);	
				} 
			</script>							
		</div>
	</body>
</html>