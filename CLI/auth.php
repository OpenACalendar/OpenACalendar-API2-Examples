<?php

include 'conf.php';
include 'lib.php';

################### DO WE NEED TO GET USER AUTH?

if (!$USER_TOKEN && !$USER_SECRET) {

	################## Step 1: Get Request Token
	print "Getting Request Token, Please wait ...\n\n";
	$response = getPostToIndexAPIResponseJSON('/api2/request_token.json',array(
			'app_token'=>$APP_TOKEN,
			'app_secret'=>$APP_SECRET,
			'callback_display'=>'true',
			'scope'=>'permission_editor',
		));

	if (!$response->success) {
		var_dump($response);
		die("There was a problem getting the request token\n\n");
	}


	################## Step 2: User gets Auth tocken
	$userURL = $INDEX_SITE_URL.'/api2/login.html?app_token='.$APP_TOKEN.'&request_token='.$response->request_token;

	print "Please go to this URL:\n\n".$userURL."\n\nPlease get the authorisation token and paste it here:\n\n";

	$auth_token = null;
	do {
		$handle = fopen ("php://stdin","r");
		$auth_token = trim(fgets($handle));
		fclose($handle);
	} while(!$auth_token);

	################## Step 3: Get User Tokens
	print "Getting User Token, Please wait ...\n\n";
	$response = getPostToIndexAPIResponseJSON('/api2/user_token.json',array(
			'app_token'=>$APP_TOKEN,
			'app_secret'=>$APP_SECRET,
			'request_token'=>$response->request_token,
			'authorisation_token'=>$auth_token,
		));

	if (!$response->success) {
		var_dump($response);
		die("There was a problem getting the user token\n\n");
	}

	$USER_TOKEN = $response->user_token;
	$USER_SECRET = $response->user_secret;
	
	print "Got User Token:\n".$USER_TOKEN."\n\n";
	// Yes, you shouldn't really let the user get their user secret but this is a DEMO script
	print "Got User Secret:\n".$USER_SECRET."\n\n";
	

} else {
	print "We already have a user token and user secret!\n";
}



