<?php
$_PATH =  $_SERVER['DOCUMENT_ROOT'];
session_start();

require_once($_PATH.'/includes/_connect.inc.php');

function parseUri(){
	$uri = $_SERVER['REQUEST_URI'];
	$parts = explode('/',$uri);
	return $parts;
}

require_once($_PATH.'/functions/getView.func.php');

require_once($_PATH.'/functions/processForm.func.php');

function isLoggedIn(){
	// Simple function to make sure user is logged in
	if ( isset($_SESSION['logged']) && $_SESSION['logged'] === 1 ){
		return true;
	}
	else{
		return false;
	}
}

function isMod(){
	// check if user is a mod for the region they're viewing
	if ( isset($_SESSION['user_level']) && $_SESSION['user_level'] == 3 ){
		return true;
	}
	else{
		return false;
	}
}

function isSameRegion($region){
	// check if the user is in the same region as the player/region being viewed
	if ( isset($_SESSION['region']) && $_SESSION['region'] == $region ){
		return true;
	}
	else{
		return false;
	}
}

function logout(){
	session_start();
	session_unset();
	setcookie('user', null, -1, '/');
	header('Location:/page/home/');
}



function simFail(){
	header('location:/page/fail/');
}

?>
