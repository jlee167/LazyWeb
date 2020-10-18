<?php
   /*
	*	File: 
	*			user_register.php
	*	Usage: 
	*			Handle user registration and user info retrieval routines.
	*			Local MySQL database is used to store user and stream address info. 
	*
	*/



	// TODO: Credentials should be moved out of php file
	$servername = "localhost";
	$username = "root";
	$password = "Wldnjs179@";
	$name_db = "LazyWeb";




	class User {
		// Personal info
		public $uid;
		public $email;
		public $name;  
		public $profile_picture;

		// Authorization Info
		public $access_token;
		public $authenticator;	

		// Peers
		public $guardians;
		public $protectees;
		public $request_guardian;
		public $request_protectee;


		function __construct(){
			$guardians = array();
			$protectees = array();
			$request_guardian = array();
			$request_protectee = array();
		}


		function getInfo($query_result){
			$this->$uid 	= $query_result["uid"];
			$this->$email 	= $query_result["email"];
			$this->$name 	= $query_result["name"];  
			$this->$profile_picture = $query_result["profile_picture"];
		}


		function registerPeer($peer_query_result, $auth_status, $peerType){
			$peer = new Peer($peer_query_result, $auth_status); 
			if ($peerType === Peer::$RC_GUARDIANS)
				array_push($guardians, $peer);
			else if ($peerType === Peer::$RC_PROTECTEES)
				array_push($protectees, $peer);
			else if ($peerType === Peer::$RC_GUARDIAN_REQUESTS)
				array_push($request_guardian, $peer);
			else if ($peerType === Peer::$RC_PROTECTEE_REQUESTS)
				array_push($request_protectee, $peer);
		}
	}


	class Peer {
		public $uid;
		public $name;
		public $phone;
		public $email;
		public $id_stream;
		public $id_profile_picture;


		public static $RC_GUARDIANS = 0;
		public static $RC_PROTECTEES = 1;
		public static $RC_GUARDIAN_REQUESTS = 2;
		public static $RC_PROTECTEE_REQUESTS = 3;

		function __construct($info_query_result, $auth_status) {
			$this->$name = $info_query_result["name"];
			$this->$phone = $info_query_result["phone"];
			$this->$email = $info_query_result["email"];
			$this->$status = $info_query_result["status"];
			
			if ($auth_status === false) {
				$this->$id_profile_picture = "Unauthorized";
				$this->$id_stream = "Unauthorized";
			}
			else {
				$this->$id_profile_picture = $info_query_result["id_profile_picture"];
				$this->$id_stream = $info_query_result["id_stream"];
			}
		}
	}


    class MySqlCredentials {
        // Credentials
		private $server; 
		private $user; 
		private $password_; 
        
        function __construct($server ,$user ,$password, $db) {
            $this->server = $server;
            $this->user = $user;
            $this->password = $password;
        }
    }


	class MySqlHandler {

        // DB Credentials
        public $credentials;

        // DB Connection Handle
		private $conn;

		// Queries
		public $query;
        public $response;

        public $current_db;
        

        function __construct($credentials) {
            $this->credentials = $credentials;
        }

        function select_db($db) {
            $this->current_db = $db;
        }

        function change_db($db) {
            $sql = "USE " + $this->$database->$db + ";";
            $result = mysqli_query($conn, $sql);

            // Exception Handling
            $this->current_db = $db;
            return true;
            // Exception Handling
            return false;
        }

		function connect() {
            $this->$conn = new mysqli(  $this->credentials->server, 
                                        $this->credentials->user, 
                                        $this->credentials->password_, 
                                        $this->current_db);

			if (mysqli_connect_error()) {
				$this->handleConnError();
			}
			else {
				$dbg_msg="Connected successfully";
				$msg = "<p>" . $dbg_msg . "</p>";
				$sql = "USE " + $this->$database->$db + ";";
				$result = mysqli_query($conn, $sql);
			}			
		}


		function handleConnError() {
			die("Database connection failed: " . mysqli_connect_error());
			$dbg_msg="Connection Failed";
			$msg = "<p>" . $dbg_msg . "</p>";
			$err_response->response = "Database Initialization Failed";
			$resp_json_format = json_encode($err_response);
			echo $resp_json_format;
			exit;
		}

		function query_single($sql) {
			$this->response = mysqli_query($this->conn, $sql);			
		}

		function getResponse() {
			return $this->response;
		}
	}


	function err_msg($msg) {
		$err_response->response = $msg;
		$resp_json_format = json_encode($err_response);
		echo $resp_json_format;
	}


    /*
        Connect to MySql Database
    */
    $credential = MySqlCredentials($servername, $username, $password);
    $mySqlHandler = MySqlHandler($credential);
    $mySqlHandler.select_db($name_db);
    $mySqlHandler.connect();


    /*
        Get REST API Request and decode json data into request packet.
    */
	$str_json = file_get_contents('php://input');
	$msg_client = json_decode($str_json, true);
	
	$request = $msg_client["Request"];
	$access_token = $msg_client["Access Token"];
	$authenticator = $msg_client["Authenticator"];	

    // Http Test code for simple testing.
    // Todo: Delete
	if ($request == "Http Test") {
		$resp_test->response="OK";
		$str_json_format = json_encode($resp_test);
		echo $str_json_format;
		exit;
	}
	 
	// autheticator is null
	if (empty($authenticator)) {
		echo "Server error: Empty Authenticator Field\n";
		exit;
	}
	// access token is null
	if (empty($access_token)) {
		echo "Server error: Empty access token\n";
		exit;
	}
	// autenticator is not an expected party
	if (($authenticator != "Google") && ($authenticator != "Kakao")) {
		echo "Server error: Invalid Authenticator \n";
		exit;
	}


	header('Content-Type: application/json; charset=utf-8');



	/*
		Block: 
			User info extraction block.

		Desc:
			Extracts user's information from his/her social login token.
		
		Todo:
			Currently, only social login is permitted.
			Future version should allow users to connect with non-social accounts.
	*/


	// Get info from Kakao user.
	if ($authenticator == "Kakao") {
		/*
		 		Make Rest API Request to Kakao.
		 		Response includes account information for user registration and sign in process.
		 */
		$authorization = 'Authorization: Bearer ' . $access_token;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $access_token));
		curl_setopt($ch, CURLOPT_URL, 'https://kapi.kakao.com/v2/user/me');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		
		// Get http response
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);	
		
		//echo "access_token: " . $access_token . "\n";
		//echo 'http code: ' . $http_code . "\n";	
		
		//echo $result;
		$result = json_decode($result, true);
		 
		$uid = $result["id"];
		$name = $result["properties"]["nickname"];
		$email = $result["kakao_account"]["email"];
		$profile_picture = $result["kakao_account"]["profile"]["thumbnail_image_url"];
		$streampath=md5($uid);
		
		if (!$result) {
			echo 'No response from Kakao Auth Server \n';
			exit;
		 }
	}

	require_once 'vendor/autoload.php';
	
	// Get $id_token via HTTPS POST.
	//$token_google = $_POST["GoogleLogin"];
	

	// Get info from Google user.
	if ($authenticator == "Google") {
	
		// Specify the CLIENT_ID of the app that accesses the backend
		$client = new Google_Client(['494240878735-c8eo6b0m0t8fhd8vo2lcj0a9v6ena7bp.apps.googleusercontent.com' => $CLIENT_ID]);  
		
		if ($access_token) {
			$payload = $client->verifyIdToken($access_token);
		}
		
		if ($payload) {
			$uid = $payload['sub'];
			$email = $payload['email'];
			$verified=$payload['email_verified'];
			$name = $payload['name'];  
			$profile_picture = $payload['picture'];
			$streampath=md5($uid);
		} else {
			// Invalid ID token
			echo "PHP server error: Invalid access token\n";
			exit;
		}
			
		if ($verified == 0) {
			echo 'Google token is not verified \n';
			exit;
		}	
	}


	if ($request != "Registration") {
		// Request other than new user registration filters out unregistered users.
		$sql = "SELECT * FROM users WHERE uid='$uid'; ";
		$result = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result) == 0) {
			$err_response->response = "Not a registered user";
			$resp_json_format = json_encode($err_response);
			echo $resp_json_format;
			exit;
		}
	} 

	/* 
	 *	New user registration. Register user into user is not already enlisted in database
	 */
	if ($request == "Registration") {
		$sql = "SELECT * FROM users WHERE uid='$uid' ";
		echo $sql;
		$result = mysqli_query($conn, $sql);
		
		if(mysqli_num_rows($result) == 0) {	
			$sql = "INSERT INTO users(uid, authenticator, name, email, phone, id_stream, status, id_profile_picture) 
						values('$uid','$authenticator', '$name','$email','Not Provided','$streampath', '0', '$profile_picture')";
			echo $sql;
			$result = mysqli_query($conn, $sql);
		}
	}
	
	/*
		Return signed user's information
	*/
	else if ($request == "My Info") {
		$usr_data = mysqli_fetch_assoc($result);
		echo json_encode($usr_data);
	}

	
	/* 
		Retrieve information about cliet's protectees and protectors
	*/
	else if ($request == "Peer List") {
		$sql = "SELECT * FROM authentication WHERE uid_guardian = '$uid' OR uid_protectee = '$uid' ";
		$result = mysqli_query($conn, $sql);
		
		// User's protectee and protectors
		$guardians = array();
		$protectees = array();
		
		// Requests for client to be protector
		$request_guardian = array();
		
		// Requests for client to be protectee
		$request_protectee = array();
		
		// Process query results: append peers to appropriate array defined above
		while ($row_data = mysqli_fetch_assoc($result)) {
			
			if ($row_data["uid_guardian"] == $uid) {
				$uid_protectee = $row_data["uid_protectee"];
				$query_peer_info = "SELECT * FROM users WHERE uid='$uid_protectee'";
				
				$peerinfo_query = mysqli_query($conn, $query_peer_info);
				$protectee_info = mysqli_fetch_assoc($peerinfo_query);
				
				if ($row_data["status"] == 0) {
					$peer_info->name = $protectee_info["name"];
					$peer_info->id_profile_picture = "Unauthorized";
					$peer_info->phone = $protectee_info["phone"];
					$peer_info->email = $protectee_info["email"];
					$peer_info->id_stream = "Unauthorized";
					$peer_info->status = $protectee_info["status"];
					array_push($request_protectee, $peer_info);
				}
				else if ($row_data["status"] == 1) {
					$peer_info->name = $protectee_info["name"];
					$peer_info->id_profile_picture = $protectee_info["id_profile_picture"];
					$peer_info->phone = $protectee_info["phone"];
					$peer_info->email = $protectee_info["email"];
					$peer_info->id_stream = $protectee_info["id_stream"];
					$peer_info->status = $protectee_info["status"];
					array_push($protectees, $peer_info);
				}
			}
			else if ($row_data["uid_protectee"] == $uid) {
				$uid_guardian = $row_data["uid_guardian"];
				$query_peer_info = "SELECT * FROM users WHERE uid='$uid_guardian';";
				$peerinfo_query= mysqli_query($conn, $query_peer_info);
				$guardian_info = mysqli_fetch_assoc($peerinfo_query);
				
				if ($row_data["status"] == 0) {
					$peer_info->name = $guardian_info["name"];
					$peer_info->id_profile_picture = $guardian_info["id_profile_picture"];
					$peer_info->phone = $guardian_info["phone"];
					$peer_info->email = $guardian_info["email"];
					$peer_info->id_stream = $guardian_info["id_stream"];
					$peer_info->status = $guardian_info["status"];
					array_push($request_guardian, $peer_info);
				}
				else if ($row_data["status"] == 1) {
					$peer_info->name = $guardian_info["name"];
					$peer_info->id_profile_picture = $guardian_info["id_profile_picture"];
					$peer_info->phone = $guardian_info["phone"];
					$peer_info->email = $guardian_info["email"];
					$peer_info->id_stream = $guardian_info["id_stream"];
					$peer_info->status = $guardian_info["status"];
					array_push($guardians, $peer_info);
				}
			}
		}
		
		$response_object->protectees = $protectees;
		$response_object->request_protectee = $request_protectee;
		$response_object->guardians = $guardians;
		$response_object->request_guardian = $request_guardian;
		$resp_encoded = json_encode($response_object);
		echo $resp_encoded;
	}
		

	/* 
		Desc:
			Client requested a new peer relationship or an update on existing one. 
			Find user from database and send request to that user. 
	*/
	else if ($request == "New Peer Request") {

		// Specify the type of peer relationship and find the requested user from database
		if ($msg_client["Request Type"] == "New Guardian") {
			$email_guardian = $msg_client["Target User Email"];
			$sql = "SELECT * FROM users WHERE email='$email_guardian' ";
			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) == 0) {
				err_msg("No result from query!\n");
				exit;
			}
			$result = mysqli_fetch_assoc($result);
			
			$uid_guardian = $result["uid"];
			$uid_protectee = $uid;
		}
		else if ($msg_client["Request Type"] == "New Protectee") {
			
			$email_protectee = $msg_client["Target User Email"];
			$sql = "SELECT * FROM users WHERE email='$email_protectee' ";
			$result = mysqli_query($conn, $sql);
			if (mysqli_num_rows($result) == 0) {
				err_msg("No result from query!\n");
				exit;
			}
			$result = mysqli_fetch_assoc($result);
			
			$uid_guardian = $uid;
			$uid_protectee = $result["uid"];
		}
		
		$action = $msg_client["Action"];	// Specicies action to be taken. 
											// Accept or Decline existing request, or Create a new one
		
		
		$sql = "SELECT * FROM authentication WHERE uid_guardian = '$uid_guardian' AND uid_protectee = '$uid_protectee'  ";
		$result = mysqli_query($conn, $sql);
		
		// Accept or declne existing request
		if ( ($action == "Accept") || ($action == "Decline")) {
			
			// Error: Request is not present in the database 
			if (mysqli_num_rows($result) == 0) {
				err_msg("No result from query!\n");
				exit;
			}
			
			// Fetch the request
			$result = mysqli_fetch_assoc($result);
			
			// Error: Request was already approved
			if ($result["status"] != 0) {
				err_msg("Request was already approved");
			}
			
			if ($action == "Accept") {
					$sql = "UPDATE authentication SET status = 1 WHERE uid_guardian = 
							'$uid_guardian' AND uid_protectee = '$uid_protectee' ";
			}
			else if ($action == "Decline") {
					$sql = "UPDATE authentication SET status = 2 WHERE uid_guardian = 
							'$uid_guardian' AND uid_protectee = '$uid_protectee' ";
			}
			$result = mysqli_query($conn, $sql);
		}
		
		// Make new request
		else if ($action == "Create") {
			
			// Error: Request already exists
			if (mysqli_num_rows($result) != 0) {
				err_msg("Already requested!\n");
				exit;
			}
			
			// Get protectee's stream address
			$sql = "SELECT * FROM users WHERE uid = '$uid_protectee'  ";
			$result = mysqli_query($conn, $sql);
			$result = mysqli_fetch_assoc($result);
			$stream_protectee = $result["id_stream"];
			
			// Todo: Currently, stream access and location access requests are made together.
			// 			 Will possiblyseparate the requeests in the future.
			$sql = "INSERT INTO authentication (uid_guardian, uid_protectee, auth_stream, auth_location, id_stream, status)
											values('$uid_guardian', '$uid_protectee', true, true, '$stream_protectee' ,0) ";
			
			$result = mysqli_query($conn, $sql);
		}
	}
	
	/*
			Emergency request received from clients.
			Handle the request by updating status information and notifying guardians.
	*/
	else if ($request == "Emergency Protocol Activation") {
		
		$sql = "UPDATE users SET status = 1 WHERE uid='$uid' ";		
		mysqli_query($conn, $sql);
		
		$sql = "SELECT * FROM authentication WHERE uid_protectee = '$uid'  AND status = 1";
		$result = mysqli_query($conn, $sql);
		
		while (mysqli_num_rows($result) > 0) {
			$uid_guardian = $result["uid_guardian"];
			$sql = "SELECT * FROM users where uid = '$uid_guardian' ";
			$result = mysqli_query($conn, $sql);
			// Todo: 	Send message to guardians via SMS or mobile/desktop application.
			//				If short on time, this functionality will be done by clients by polling their protectee's status periodically.
		}
	}
	
	/*
			Client indicated situation is over/resolved.
			Update status information and notify guardians.
	*/
	else if ($request == "Emergency Protocol Dectivation") {
		$sql = "UPDATE users SET status = 0 WHERE uid='$uid' ";
		
		// Todo: Add error case handlers
		
		// Todo: 	Send message to guardians via SMS or mobile/desktop application.
		//				If short on time, this functionality will be done by clients by polling their protectee's status periodically.
	}
?>