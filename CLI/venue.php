<?php

include 'conf.php';
include 'lib.php';



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

################### Get venue 
print "Getting Venue, Please wait ...\n\n";
$venueID = 1;
$venueJSON = getGetToSiteAPIResponseJSON('/api2/venue/'.$venueID.'/info.json',array(
			'app_token'=>$APP_TOKEN,
			'user_token'=>$USER_TOKEN,
			'user_secret'=>$USER_SECRET,
		));


var_dump($venueJSON);


################### Posting venue 
if ($currentUserOnSiteResponse->permissions->is_editor) {
	print "Posting Venue, Please wait ...\n\n";
	$venueWriteJSON = getPostToSiteAPIResponseJSON('/api2/venue/'.$venueID.'/info.json',array(
				'app_token'=>$APP_TOKEN,
				'user_token'=>$USER_TOKEN,
				'user_secret'=>$USER_SECRET,
				'title'=>$venueJSON->venue->title." [API]",
				'description'=>$venueJSON->venue->description." [API]",
				'address'=>$venueJSON->venue->address." [API]",
				'address_code'=>$venueJSON->venue->address_code." [API]",
				'lat'=>$venueJSON->venue->lat + 0.5,
				'lng'=>$venueJSON->venue->lng + 0.5,
			));


	var_dump($venueWriteJSON);
}


