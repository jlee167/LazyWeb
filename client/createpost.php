<!doctype html>

<?php
	// TODO: Credentials moved out of php file
	$servername = "localhost";
	$username = "root";
	$password = "Wldnjs179@";
	$dbname = "dashboard";

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
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/style.css">		
		<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
				
		<meta name="viewport" content="width=device-width, initial-scale=1">	

		<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-bs4.min.js"></script>
	</head>
	
	<body style="background-color:#d6eaf8; margin:0; overflow:hidden;">		
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
						<a class="nav-link" href="support.html">Support</a>
					</li>
					<li class="nav-item"> <a class="nav-link" href="broadcast.php">Emergency Broadcast </a></li>
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
		

		

		<div style="margin:auto; width:100%;height:100%;">
			<form action="createpost.php" method="post" style="margin:auto; margin-top:100px; width:60%;height:60%;">
				<input type="hidden" id="postToken" name="postToken"> 
				<label for="title" style="width:100%;">Title</label><br>
				<input type="text" id="title" name="title" style="width:100%; min-width:500px;"><br>
				<label for="content" style="width:100%">Content</label><br>
				<textarea id="summernote" name="content" style="width:100%; min-width:500px; height:60%;"></textarea><br>
				<input class="btn btn-primary" type="submit" value="submit" style="float:right; margin-top:15px; width: 100px;">
			</form>
		</div>


		<script>
		$('#summernote').summernote({
		placeholder: 'content',
		tabsize: 2,
		height: 200
		});
		</script>
		
		<script src="js/cookie_handler.js"></script>
		<script>
			var googleToken = getCookie('GoogleToken' );
			document.getElementById('postToken').value=googleToken;
			console.log(googleToken);
		</script>
		
		<?php
			require_once 'vendor/autoload.php';
			
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$postToken = $_POST['postToken'];
				
				// Specify the CLIENT_ID of the app that accesses the backend
				$client = new Google_Client(['494240878735-c8eo6b0m0t8fhd8vo2lcj0a9v6ena7bp.apps.googleusercontent.com' => $CLIENT_ID]);  
				
				$email='';
				
				if ($postToken)
					$payload = $client->verifyIdToken($postToken);
				
				if ($payload) {
					$email = $payload['email'];
				} else {
				  echo 'Invalid ID token';
				}
				
				$title = $_POST['title'];
				$content = $_POST['content'];
				$sql = "USE dashboard;";
				$result = mysqli_query($conn, $sql);
				$sql = "INSERT INTO mainboard(author, title, content, hit_cnt) values('$email', '$title', '$content','0');";
				$result = mysqli_query($conn, $sql);
			}		
		?>
	</body>


<html>