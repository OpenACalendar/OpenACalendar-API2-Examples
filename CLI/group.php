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

################### Get group 
print "Getting Group, Please wait ...\n\n";
$groupID = 1;
$groupJSON = getGetToSiteAPIResponseJSON('/api2/group/'.$groupID.'/info.json',array(
			'app_token'=>$APP_TOKEN,
			'user_token'=>$USER_TOKEN,
			'user_secret'=>$USER_SECRET,
		));


var_dump($groupJSON);


################### Posting group 
if ($currentUserOnSiteResponse->permissions->is_editor) {
	print "Posting Group, Please wait ...\n\n";
	$groupWriteJSON = getPostToSiteAPIResponseJSON('/api2/group/'.$groupID.'/info.json',array(
				'app_token'=>$APP_TOKEN,
				'user_token'=>$USER_TOKEN,
				'user_secret'=>$USER_SECRET,
				'title'=>$groupJSON->group->title." [API]",
				'description'=>$groupJSON->group->description." [API]",
				'url'=>($groupJSON->group->url ? $groupJSON->group->url."?api=1" : "http://ican.openacalendar.org/"),
			));


	var_dump($groupWriteJSON);
}


