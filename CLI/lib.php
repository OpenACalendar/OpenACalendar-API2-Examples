<?php



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



