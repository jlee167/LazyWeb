<html>
	<head>
		<!-- Import Custom stylesheets -->
		<link rel="stylesheet" href="css/style.css">	
		<!-- Import Bootstrap CDN -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

		<meta charset="utf-8">
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
			
	</head>
	
	<body>		
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
				console.log(peerlist.request_protectee.length);
				update_table();
			};
			
			console.log(JSON.stringify(peerlist_request));	
			xhttp.send(JSON.stringify(peerlist_request));
		</script>
		
		<script>
			var authenticator = getCookie('Authenticator' );
			var username = getCookie('Username' );
			var profilePicture = getCookie('ProfilePicture' );
			var signInContainer = document.getElementById("signInContainer");
			var userProfileUI = document.getElementById("userInfoUI");
			updateLoginUI(authenticator, username, signInContainer, userProfileUI, profilePicture);
		</script>
		

		
		<div class="container-fluid" style="width:70%;">
			<h1 style="text-align:center; margin-top:30px;"> Peers </h1>
			<div style="margin-bottom:10px;">
				<table style="width:100%;">
					<tr>
						<td style="width:10%"> <a id="refreshBtn"class="btn btn-primary" href="" role="button" style="text-align:center; width:140px; height:40px; float:left; margin: auto;" > Refresh	</a></td>
						
						<td style="width:40%" >
							<p><p>
						</td>
						
						<td  style="text-align: center; vertical-align: middle;">
							<p style="display:flex; justify-content: center;"> <b>Add User (email): </b> </p>
						</td>
						<td  style="text-align: center; vertical-align: middle;">
							<input type="text" id="peer_email" name="peer_email" style="text-align:center; width:200px; height:40px; float:right; margin: auto;">
							
						</td>
						<td style="text-align: center; vertical-align: middle;">
							<a id="newProtecteeRequestBtn"class="btn btn-primary"  role="button" style="text-align:center; width:140px; height:40px; float:right; margin-left: 10px;" > As Protectee	</a>
						</td>
						<td  style="text-align: center; vertical-align: middle;">
							<a id="newGuardianRequestBtn"class="btn btn-primary"  role="button" style="width:140px; height:40px; float:right; margin-left:10px;" > As Guardian	</a>
						</td>
					</tr>
				</table>
			</div>
			
			<script src="js/cookie_handler.js"></script>
			<script>
				newGuardianRequestBtn.onclick = function () {
					xhttp.open('POST', 'user_register.php', true);
					var newpeer_request = {
						"Request" : "New Peer Request",
						"Action" : "Create",
						"Access Token" : accessToken,
						"Authenticator" : authenticator,
						"Request Type": "New Guardian",
						"Target User Email": document.getElementById("peer_email").value
					};	
					console.log(newpeer_request);
					xhttp.send(JSON.stringify(newpeer_request));
				}
				
				newProtecteeRequestBtn.onclick = function () {
					xhttp.open('POST', 'user_register.php', true);
					var newpeer_request = {
						"Request" : "New Peer Request",
						"Action" : "Create",
						"Access Token" : accessToken,
						"Authenticator" : authenticator,
						"Request Type": "New Protectee",
						"Target User Email": document.getElementById("peer_email").value
					};	
					console.log(newpeer_request);
					xhttp.send(JSON.stringify(newpeer_request));
				}
			</script>	

			
			<table class="table table-striped" style="margin:auto; text-align:center; width:100%;">
				<thead>
					<tr>					
						<th style="width:10%;">Portrait</th>
						<th style="width:20%;">Full Name</th>
						<th style="width:20%;">Phone</th>
						<th style="width:10%;">Email</th>
						<th style="width:20%;">Stream</th> 
						<th style="width:10%;">Status</th> 
						<th style="width:10%;">Action</th> 
					</tr>
				</thead>
				
				<tbody id= "peerlist_table">
				</tbody>	
			</table>	
			
			<script>
				function update_table() {
					
					var peerlist_content = document.getElementById("peerlist_table");
					if (peerlist != null) {
						
						for (var i = 0; i < peerlist.request_protectee.length; i = i + 1) {
							var actionBtn = '<a id="acceptBtn"class="btn btn-primary"  role="button" style="text-align:center; width:70px; height:40px; float:right; margin: auto;" > Accept	</a><a id="declineBtn"class="btn btn-primary"  role="button" style="text-align:center; width:70px; height:40px; float:right; margin: auto;" > Decline	</a>';
							console.log(i);
							peerlist_content.innerHTML += peerlist_content.innerHTML + 
																		"<tr><td style='width:10%;'>"  + "<img src =' " +  peerlist.request_protectee[i]['id_profile_picture'] + " '></img>" +  
																		"</td><td style='width:40%;'>" + peerlist.request_protectee[i]['name'] + 
																		"</td><td style='width:20%;'>" + peerlist.request_protectee[i]['phone'] +  
																		"</td><td style='width:20%;'>" + peerlist.request_protectee[i]['email'] + 
																		"</td><td style='width:10%;'>" + peerlist.request_protectee[i]['id_stream'] + 
																		"</td><td style='width:10%;'>" + peerlist.request_protectee[i]['status'] + 
																		"</td><td style='width:10%;'>"  + actionBtn +
																		"</td></tr>";
						}
						
						for (var i = 0; i < peerlist.protectees.length; i = i + 1) {
							console.log(i);
							peerlist_content.innerHTML += peerlist_content.innerHTML + 
																		"<tr><td style='width:10%;'>"  + "<img src =' " +  peerlist.protectees[i]['id_profile_picture'] + " '></img>" +  
																		"</td><td style='width:40%;'>" + peerlist.protectees[i]['name'] + 
																		"</td><td style='width:20%;'>" + peerlist.protectees[i]['phone'] +  
																		"</td><td style='width:20%;'>" + peerlist.protectees[i]['email'] + 
																		"</td><td style='width:10%;'>" + peerlist.protectees[i]['id_stream'] + 
																		"</td><td style='width:10%;'>" + peerlist.protectees[i]['status'] + 
																		"</td><td style='width:10%;'>"  + actionBtn +
																		"</td></tr>";
						}
						
					}
				}
			</script>
		</div>
	</body>
</html>