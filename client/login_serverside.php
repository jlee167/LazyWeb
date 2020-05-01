<?php 
	header("Access-Control-Allow-Origin: *");
	require_once 'vendor/autoload.php';
	// Get $id_token via HTTPS POST.
	$client = new Google_Client(['client_id' => $1083086831094-qatr04h8rnthlm9501q2oa45mjkjh4r0]);  // Specify the CLIENT_ID of the app that accesses the backend
	$payload = $client->verifyIdToken($id_token);
	if ($payload) {
	  $userid = $payload['sub'];
	  // If request specified a G Suite domain:
	  //$domain = $payload['hd'];
	} else {
	  // Invalid ID token
	}		
?>