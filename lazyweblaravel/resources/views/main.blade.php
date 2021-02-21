<!doctype html>

<html>
	<head>
		@include('includes.imports.styles_common')
	</head>


	<body>
        @include('includes.layouts.navbar')

		<script src="/js/auth_helpers.js"></script>
		<script>
			var authenticator = getCookie('Authenticator');
			var username = getCookie('Username' );
			var profilePicture = getCookie('ProfilePicture' );
			var signInContainer = document.getElementById("signInContainer");
			var userProfileUI = document.getElementById("userInfoUI");
			updateLoginUI(authenticator, username, signInContainer, userProfileUI, profilePicture);
		</script>



		<div class="section-contents">
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
			<div style="height:auto; background-color:rgb(238, 238, 238);">
				<div class="container" style="padding-top:40px;padding-bottom:40px;">
					<div style="display:inline-flex;">
						<div class="card col-md-4" style="margin-right:20px; background-color:transparent;">
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

            @include('includes.layouts.footer')
		</div>

	</body>
</html>
