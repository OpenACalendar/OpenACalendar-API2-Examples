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

################### Get event 
print "Getting Event, Please wait ...\n\n";
$eventID = 1;
$eventJSON = getGetToSiteAPIResponseJSON('/api2/event/'.$eventID.'/info.json',array(
			'app_token'=>$APP_TOKEN,
			'user_token'=>$USER_TOKEN,
			'user_secret'=>$USER_SECRET,
		));


var_dump($eventJSON);


################### Posting event 
if ($currentUserOnSiteResponse->permissions->is_editor) {
	print "Posting Event, Please wait ...\n\n";
	$eventWriteJSON = getPostToSiteAPIResponseJSON('/api2/event/'.$eventID.'/info.json',array(
				'app_token'=>$APP_TOKEN,
				'user_token'=>$USER_TOKEN,
				'user_secret'=>$USER_SECRET,
				'summary'=>$eventJSON->event->summary." [API]",
				'url'=>($eventJSON->event->url ? $eventJSON->event->url."?api=1" : "http://ican.openacalendar.org/"),
				'ticket_url'=>($eventJSON->event->ticket_url ? $eventJSON->event->ticket_url."?api=1" : "http://ican.openacalendar.org/"),
			));


	var_dump($eventWriteJSON);
}


