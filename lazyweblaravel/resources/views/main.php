<!doctype html>

<html>
	<head>
		<!-- Import Bootstrap CDN -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<!-- Import Custom stylesheets -->
		<link rel="stylesheet" href="css/style.css">		
		<meta charset="utf-8">
		
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</head>
	
	<!--body style="background:linear-gradient(to bottom, rgba(0,0,0,0) 20%, rgba(0,0,0,1)), url('img/main_background.jpg');"-->
	<body>
		<?php 
			use Illuminate\Support\Facades\View;
			echo view('navbar');
		?>
			
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
		
		<div id="main-contents" style="overflow:hidden; width:100%; padding-top:100px;">
		<script>
			var contents_height = window.innerHeight - document.getElementById("main_nav").height;
			//document.getElementById("main-contents").height = contents_height;
			console.log("hi");
			console.log(contents_height);
		</script>
			<div class="contents" style="height:70vh;">
				<div style="width:100%; height:100%; float:left; margin:auto; display:flex; justify-content:center;">
					<div id="carouselExampleControls" class="carousel slide" data-ride="carousel" style="margin:auto; width:100%; height:100%; background-color:#5a5a5a;">
						<ol class="carousel-indicators">
							<li data-target="#carouselExampleControls" data-slide-to="1"></li>
							<li data-target="#carouselExampleControls" data-slide-to="2"></li>
							<li data-target="#carouselExampleControls" data-slide-to="3"></li>
						</ol>
						
					  <div class="carousel-inner " style="width:100%; height:100%;color:#5a5a5a;">
					  
						<div class="carousel-item active" style="width:100%; height:100%;">
							<div style=" width:100%; height:100%"> 
										<div style="background-color:black; color: white; width:15%; min-width:200px; height:100%; float:right;"> 
											<p style="width:100%; height:100%; display: flex; justify-content: center; align-items: center;"><b> RTL / FPGA </b></p>
										</div>
										<div style="background-image:linear-gradient(to right, rgba(0,0,0,0) 70%, rgba(0,0,0,1)), url('img/main_background.jpg'); width:85%; height:100%"> 
										</div>
								</div>
						</div>
						
						<div class="carousel-item " style="width:100%; height:100%;">
							<div style=" width:100%; height:100%"> 
										<div style="background-color:black; color: white; width:15%; min-width:200px; height:100%; float:right;"> 
											<p style="width:100%; height:100%; display: flex; justify-content: center; align-items: center;"><b> Hardware </b></p>
										</div>
										<div style="background-image:linear-gradient(to right, rgba(0,0,0,0) 70%, rgba(0,0,0,1)), url('img/main_background.jpg'); width:85%; height:100%"> 
										</div>
								</div>
						</div>
						
						<div class="carousel-item " style="width:100%; height:100%;">
							<div style=" width:100%; height:100%"> 
									<div style="background-color:black; color: white; width:15%; min-width:200px; height:100%; float:right;"> 
										<p style="width:100%; height:100%; display: flex; justify-content: center; align-items: center;"><b> Software </b></p>
									</div>
									<div style="background-image:linear-gradient(to right, rgba(0,0,0,0) 70%, rgba(0,0,0,1)), url('img/main_background.jpg'); width:85%; height:100%"> 
								</div>
							</div>
						</div>
						
					  </div>
					  
					  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev" style="color:black;">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					  </a>
					  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next" style="color:black;">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					  </a>
					</div>
				</div>
			</div>
			<div class="contents" style="background-color:#f8f8f8; height:auto; padding-top:40px;padding-bottom:40px;">
				<div class="container">
					<div style="display:inline-flex;">
						<div class="card col-md-4" style="margin-right:20px;">
							<h2> Bridging the gap </h2>
							<p style="font:Georgia;"> 
								Upcoming products of Lazyboy Industry will be focused on providing entry level makers a chance to use Soc level modules on entry level Microcontroller boards.	<br><br>
								No more soldering BGA microchips. <br><br>
								No more struggle fitting in your big fat LInux boards into design just cause you can't design it on your own. <br><br>
								Just an 48 Mhz Arduino-class microcontroller will give you acces to a Full HD 1080p streaming in your product!
								Okay, it may be 720p honestly. I am still in designing process.<br>
							</p>
							<a id=""class="btn btn-primary" href="" role="button" style="width:100px; text-align:center;">
								Todo
							</a>
						</div>
						
						<div class="card col-md-4" style="margin-right:20px;">
							<h2> Ideas to product </h2>
							<p>
								Bringing your ideas to life as an amateur can be overwhelming.<br>
								Protoboards and dev boards can only take you so far when it comes to designing actual products to sell.<br>
							</p>
							<a id=""class="btn btn-primary" href="" role="button" style="width:100px; text-align:center;">
								Todo
							</a>
						</div>
						
						<div class="card col-md-4">
							<h2>Commercial use</h2>
							<p>
								Products of Lazyboy are meant to be used specifically for education and prototyping. If you want to 
								embed my modules into your commercial product, you may do so at your own risk. Lazyboy.Co Ltd 
								does not guarantee product quality for commercial use. I may however, provide technical support for
								manufacturers using my design at their own risk.
							</p>
							
							<a id=""class="btn btn-primary" href="" role="button" style="width:100px; text-align:center;">
								Todo
							</a>
						</div>
						
					</div>
				</div>
			</div>
			
			<div  class="contents" style="background-color:grey; height:100px; ">
				<div class="container" style=" height:100%; ">
					<p style="color:white; height:100%; display: flex; justify-content: center; align-items: center;">Copyright 2020 Lazyboy Industry CO.Limitied All Rights Reserved</p>
				</div>
			</div>
		</div>
			
	</body>
</html>