<?php

include 'conf.php';
include 'lib.php';

if (!$USER_TOKEN && !$USER_SECRET) {
	die("No User Token and User Secret\n");
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


