<?php
   /*
	*	File: 
	*			user_register.php
	*	Usage: 
	*			Handle user registration and user info retrieval routines.
	*			Local MySQL database is used to store user and stream address info. 
	*
	*/
?> 


<?php
	// TODO: Credentials should be moved out of php file
	$servername = "localhost";
	$username = "root";
	$password = "Wldnjs179@";
	$dbname = "dashboard";

	// Connect to login server database;
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check database connection
	if (mysqli_connect_error()) {
		die("Database connection failed: " . mysqli_connect_error());
		$dbg_msg="Connection Failed";
		$msg = "<p>" . $dbg_msg . "</p>";
	}
	else if ($conn){
		$dbg_msg="Connected successfully";
		$msg = "<p>" . $dbg_msg . "</p>";
	}
	
?> 

<?php
	header('Content-Type: application/json; charset=utf-8');
	
	// Get Kakao access token from HTTP request
	$access_token = $_POST["token_kakao"];

	// Execute if Kakao authentication token is delivered
	if (!empty($access_token)) {
		$authorization = 'Authorization: Bearer ' . $access_token;
		
		/*
		 *		Make Rest API Request to Kakao.
		 *		Response includes account information for user registration and sign in process.
		 */
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $access_token));
		curl_setopt($ch, CURLOPT_URL, 'https://kapi.kakao.com/v2/user/me');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		
		// Get http response
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		echo "access_token: " . $access_token . "\n";
		echo 'http code: ' . $http_code . "\n";
		
		
		if (!$result) {
			echo 'No response from Kakao Auth Server \n';
			
			exit;
		 }
		 else {
			 //Todo: register new user to database 
			 echo $result;
		 }			 
		curl_close($ch);	
	}
?>

<?php
	require_once 'vendor/autoload.php';
	
	
	// Get $id_token via HTTPS POST.
	$token_google = $_POST["idtoken"];
	
	// Specify the CLIENT_ID of the app that accesses the backend
	$client = new Google_Client(['494240878735-c8eo6b0m0t8fhd8vo2lcj0a9v6ena7bp.apps.googleusercontent.com' => $CLIENT_ID]);  
	
	if ($token_google) {
		$payload = $client->verifyIdToken($token_google);
	}
	if ($payload) {
		$userid = $payload['sub'];
		$email = $payload['email'];
		$verified=$payload['email_verified'];
		$firstname = $payload['name'];  
	} else {
	  // Invalid ID token
	}
	
	if ((!empty($token_google)) && ($verified == 1)) {		
		$streampath=md5(email);
		$sql = "USE USERS;";
		$result = mysqli_query($conn, $sql);
		$sql = "SELECT * FROM users WHERE email='$email';";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) > 0){	
			$row = mysqli_fetch_assoc($result);
			$sendObj->streamPath=$row["path_stream"];
			//echo $row["path_stream"];
			$myjson = json_encode(sendObj);
			//echo $myjson;
		}
		else {
			$sql = "INSERT INTO users(email, name,jwt,authtype,path_stream) values('$email','$firstname','$userid','Google','$streampath');";
			$result = mysqli_query($conn, $sql);
		}		
		echo "Test User";
	}
?>


<?php	
	// Get $id_token via HTTPS POST.
	$token_stream = $_POST["googlestream"];
	// Specify the CLIENT_ID of the app that accesses the backend
	$client = new Google_Client(['494240878735-c8eo6b0m0t8fhd8vo2lcj0a9v6ena7bp.apps.googleusercontent.com' => $CLIENT_ID]);  
	
	if ($token_stream)
		$payload = $client->verifyIdToken($token_stream);
	
	if ($payload) {
		$userid = $payload['sub'];
		$email = $payload['email'];
		$verified=$payload['email_verified'];
		$firstname = $payload['name'];  
	} else {
	  // Invalid ID token
	}
	
	if (($token_stream !== "") && ($verified == 1)) {		
		$streampath=md5(email);
		$sql = "USE USERS;";
		$result = mysqli_query($conn, $sql);
		$sql = "SELECT * FROM users WHERE email='$email';";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) > 0){	
			$row = mysqli_fetch_assoc($result);
			$sendObj->streamPath=$row["path_stream"];
			echo ltrim($row["path_stream"]);
		}
		else {
			echo $email;
		}		
	}
?>