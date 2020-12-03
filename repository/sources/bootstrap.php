<?php

// Initiate session usage
session_start();

// Create path constants for json data

define('USER_FILE', __DIR__ . '/../data/.ht_users.json');
define('EVENT_FILE', __DIR__ . '/../data/.ht_events.json');

// Create the user json if it doesn't exist
if( !file_exists(USER_FILE) ){
	file_put_contents(USER_FILE, '{}');
	$GLOBALS['USERS'] = array();
} else {
	$GLOBALS['USERS'] = json_decode(file_get_contents(USER_FILE), TRUE) ?? array();
}

// Create the events json if it doesn't exist
if( !file_exists(EVENT_FILE) ){
	file_put_contents(EVENT_FILE, '{}');
	$GLOBALS['EVENTS'] = array();
} else {
	$GLOBALS['EVENTS'] = json_decode(file_get_contents(EVENT_FILE), TRUE) ?? array();
}

// Save json data
function save(){
	return @file_put_contents(USER_FILE, json_encode($GLOBALS['USERS'])) && @file_put_contents(EVENT_FILE, json_encode($GLOBALS['EVENTS']));
}