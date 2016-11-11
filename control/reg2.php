<?php

//
// Check to make sure the user is logged in, and a regional moderator.
// Also check to make sure they haven't set their region yet. if they have, direct them to their profile
// // or whatever the admin control page becomes.
//
if ( !isLoggedIn() ){
	header('location:/page/home/');
}
if (  !isMod() ){
	header('location:/page/home/');
}
else{}

$user = $_SESSION['user'];
$chk_qry = "SELECT region_id
							FROM user_region
							WHERE user_id = $user
							AND region_id = 0";
$chk_res = $db->query($chk_qry);
$chk_cnt = $chk_res->num_rows;
// Is their region already set? Get them out of here if it is.
if ( $chk_cnt == 0 ){
	simFail();
} else{}

$region_query = "SELECT region_id, region_name, region_state FROM regions ORDER BY region_state";
$region_res = $db->query($region_query);

// Select 5 random characters for human validation
$char_qry = "SELECT char_id, char_displayName, char_fileName
						FROM characters
						WHERE char_id <= 40
						ORDER BY RAND() LIMIT 4";
$char_res = $db->query($char_qry);

$chars = array();
while ( $row = $char_res->fetch_assoc() ){
	$chars[] = $row;
}
// Reset query
$char_res->data_seek(0);

// Select a single random item. This is our key
// Save in session to check in processing.

$int = rand(0,3);
$charKey = $chars[$int];
$charKeyName = $charKey['char_displayName'];
$_SESSION['validation'] = $charKey['char_id'];

$pageTitle = "Register - Almost done..."
?>
