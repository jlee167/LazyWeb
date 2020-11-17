<!doctype html>

<?php
	// TODO: Credentials moved out of php file
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "LazyboyServer";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if (mysqli_connect_error()) {
		die("Database connection failed: " . mysqli_connect_error());
		$dbg_msg="Connection Failed";
	}
	else if ($conn){
		$dbg_msg="Connected successfully";
	}
?>

<html>
	<head>
		@include('includes.imports.styles_common')

		<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.js"></script>
	</head>

	<body>
		<script src="/js/auth_helper.js"></script>
		<script>
			var authenticator = getCookie('Authenticator' );
			var username = getCookie('Username' );
			var profilePicture = getCookie('ProfilePicture' );
			var signInContainer = document.getElementById("signInContainer");
			var userProfileUI = document.getElementById("userInfoUI");
			updateLoginUI(authenticator, username, signInContainer, userProfileUI, profilePicture);
		</script>

        @include('includes.layouts.navbar')

        <div class="section-contents">

			<form action="support.php" enctype="multipart/form-data" method="POST" style="margin:auto; margin-top:10vh; width:60%;height:80vh; margin-bottom:100px;">
				<input type="hidden" id="postToken" name="postToken">

				<label style="width:100%;">What do you need support with? </label><br>
				<input type="checkbox" id="repair" name="repair" value="reair">
				<label for="repair"> Repair  </label><br>
				<input type="checkbox" id="service" name="service" value="service">
				<label for="service2"> Service Malfunction  </label> <br>
				<input type="checkbox" id="hardware" name="hardware" value="hardware">
				<label for="hardware"> Hardware Development  </label>  <br>
				<input type="checkbox" id="software" name="software" value="software">
				<label for="software"> Software Development  </label> <br><br>

				<label for="content" style="width:100%">Content</label><br>
				<textarea id="summernote" name="content" style="width:100%; min-width:500px; height:60%;"></textarea><br>
				<input class="btn btn-primary" type="submit" value="submit" style="float:right; margin-top:15px; width: 100px;">
            </form>

            @include('includes.layouts.footer')
		</div>


		<script>
			$('#summernote').summernote({
				placeholder: 'content',
				tabsize: 2,
				height: 200
			});
		</script>

		<script>
			var googleToken = getCookie('AccessToken' );
			document.getElementById('postToken').value=googleToken;
			console.log(googleToken);
		</script>

		<?php

			if ($_SERVER["REQUEST_METHOD"] == "POST") {

				$postToken = $_POST['postToken'];

				// Specify the CLIENT_ID of the app that accesses the backend
				$client = new Google_Client(['494240878735-c8eo6b0m0t8fhd8vo2lcj0a9v6ena7bp.apps.googleusercontent.com' => $CLIENT_ID]);

				$email='';

				if ($postToken)
					$payload = $client->verifyIdToken($postToken);

				if ($payload) {
					$uid = $payload['sub'];
					$name = $payload['name'];
					$email = $payload['email'];
				} else {
					return;
				}

				$repair = $_POST['repair'];
				$service = $_POST['service'];
				$hardware = $_POST['hardware'];
				$software = $_POST['software'];
				$type = $repair . $service . $hardware . $software;
				echo $type;


				$content = $_POST['content'];
				$sql = "USE LazyWeb";
				$result = mysqli_query($conn, $sql);
				$sql = "INSERT INTO supports(uid, type, contents, status) values('$uid', '$type', '$content', '0')";
				echo $sql;
				$result = mysqli_query($conn, $sql);
				echo $result;
			}
        ?>
	</body>
</html>
