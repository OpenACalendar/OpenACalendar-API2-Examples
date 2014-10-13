<?php

$APP_TOKEN = 'appt';
$APP_SECRET = 'apps';
// For Single Site, set to the same
// For multi site, 
$INDEX_SITE_URL = 'http://hasadevcalendar.co.uk:20153';
$SITE_SITE_URL = 'http://hasadevcalendar.co.uk:20153';
// If you start with these blank, you will be guided to create them.
$USER_TOKEN = NULL;
$USER_SECRET = NULL;

################## Func

function getGetToIndexAPIResponseJSON($url, $fields) {
	global $INDEX_SITE_URL;
	
	$url = $INDEX_SITE_URL . $url . '?';
	foreach($fields as $key=>$value) { $url .= $key.'='.urlencode($value).'&'; }
	rtrim($url, '&');

	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	$result = curl_exec($ch);
	
	if (curl_errno($ch)) {
		print "CURL ERROR: ".curl_error($ch)."\n\n";
		die();
	}
	
	curl_close($ch);
	
	$jsonObj = json_decode($result);
	
	if ($jsonObj == null) {
		print "ERROR DECODING THIS JSON: ".$result."\n\n";
		die();
	}
	
	return $jsonObj;
	
}

function getPostToIndexAPIResponseJSON($url, $fields) {
	global $INDEX_SITE_URL;
	
	$fields_string = '';
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.urlencode($value).'&'; }
	rtrim($fields_string, '&');

	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL, $INDEX_SITE_URL . $url);
	curl_setopt($ch,CURLOPT_POST, true);
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	$result = curl_exec($ch);
	
	if (curl_errno($ch)) {
		print "CURL ERROR: ".curl_error($ch)."\n\n";
		die();
	}
	
	curl_close($ch);
	
	$jsonObj = json_decode($result);
	
	if ($jsonObj == null) {
		print "ERROR DECODING THIS JSON: ".$result."\n\n";
		die();
	}
	
	return $jsonObj;
		
}

function getGetToSiteAPIResponseJSON($url, $fields) {
	global $SITE_SITE_URL;
	
	$url = $SITE_SITE_URL . $url . '?';
	foreach($fields as $key=>$value) { $url .= $key.'='.urlencode($value).'&'; }
	rtrim($url, '&');

	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	$result = curl_exec($ch);
	
	if (curl_errno($ch)) {
		print "CURL ERROR: ".curl_error($ch)."\n\n";
		die();
	}
	
	curl_close($ch);
	
	$jsonObj = json_decode($result);
	
	if ($jsonObj == null) {
		print "ERROR DECODING THIS JSON: ".$result."\n\n";
		die();
	}
	
	return $jsonObj;
	
}

function getPostToSiteAPIResponseJSON($url, $fields) {
	global $SITE_SITE_URL;
	
	$fields_string = '';
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.urlencode($value).'&'; }
	rtrim($fields_string, '&');

	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL, $SITE_SITE_URL . $url);
	curl_setopt($ch,CURLOPT_POST, true);
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	$result = curl_exec($ch);
	
	if (curl_errno($ch)) {
		print "CURL ERROR: ".curl_error($ch)."\n\n";
		die();
	}
	
	curl_close($ch);
	
	$jsonObj = json_decode($result);
	
	if ($jsonObj == null) {
		print "ERROR DECODING THIS JSON: ".$result."\n\n";
		die();
	}
	
	return $jsonObj;
		
}

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
	

}

################### LETS GO!
print "Getting Current User, Please wait ...\n\n";
$currentUserResponse = getGetToIndexAPIResponseJSON('/api2/current_user.json',array(
			'app_token'=>$APP_TOKEN,
			'user_token'=>$USER_TOKEN,
			'user_secret'=>$USER_SECRET,
		));


if (!$currentUserResponse->success) {
	var_dump($currentUserResponse);
	die("There was a problem getting the user info\n\n");
}

print "User: ".$currentUserResponse->user->username."\n";
print "Permission for app is_editor :".($currentUserResponse->permissions->is_editor  ? 'yes':'no')."\n";


################### LETS GO!
print "Getting Current User On Site, Please wait ...\n\n";
$currentUserOnSiteResponse = getGetToSiteAPIResponseJSON('/api2/current_user_on_site.json',array(
			'app_token'=>$APP_TOKEN,
			'user_token'=>$USER_TOKEN,
			'user_secret'=>$USER_SECRET,
		));


if (!$currentUserOnSiteResponse->success) {
	var_dump($currentUserOnSiteResponse);
	die("There was a problem getting the user on site info\n\n");
}

print "Site: ".$currentUserOnSiteResponse->site->title."\n";
print "Permission on site is_editor :".($currentUserOnSiteResponse->permissions->is_editor  ? 'yes':'no')."\n";

################### Get area 
print "Getting Area, Please wait ...\n\n";
$areaID = 1;
$areaJSON = getGetToSiteAPIResponseJSON('/api2/area/'.$areaID.'/info.json',array(
			'app_token'=>$APP_TOKEN,
			'user_token'=>$USER_TOKEN,
			'user_secret'=>$USER_SECRET,
		));


var_dump($areaJSON);


################### Posting area 
if ($currentUserOnSiteResponse->permissions->is_editor) {
	print "Posting Area, Please wait ...\n\n";
	$areaWriteJSON = getPostToSiteAPIResponseJSON('/api2/area/'.$areaID.'/info.json',array(
				'app_token'=>$APP_TOKEN,
				'user_token'=>$USER_TOKEN,
				'user_secret'=>$USER_SECRET,
				'title'=>$areaJSON->area->title." [API]",
			));


	var_dump($areaWriteJSON);
}


