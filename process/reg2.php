<?php
$error = "";
$success = "";
$target = '';

$user = $_SESSION['user'];

$region = mysqli_real_escape_string($db, $_POST['region']);
$referer = mysqli_real_escape_string($db, $_POST['referer']);
$validInput = mysqli_real_escape_string($db, $_POST['validation']);

if ( !isset($_SESSION['validation']) || strlen($_SESSION['validation']) < 1 ){
  $error = "We were unable to process your submission. Please try again.";
  $success = 'false';
}

else if ( $_SESSION['validation'] != $validInput ){
  $error = "You selected the wrong validation option. Please try again.";
  $success = 'false';
}

if (empty($user) || empty($region) || empty($validInput)){
	$error = "You need to select a region to continue.";
	$success = 'false';
}
else{
  $qry = "SELECT region_id
  				FROM regions
  					WHERE region_id = '$region'
  					LIMIT 1";
  $qry_res = $db->query($qry);
  $reg_cnt = $qry_res->num_rows;

  if ($reg_cnt !== 1){
  	$error = "This region does not exist.";
  	$success = 'false';
  }
}
if ( $success !== 'false' ){
  $success = 'true';

	$upd_qry = "UPDATE user_region
								SET region_id = $region
								WHERE user_id = $user
								LIMIT 1";
	$db->query($upd_qry);

	if ($_SESSION['user_level'] == 2){
		$upd_qry = "UPDATE user
									SET user_level = 3
									WHERE user_id = $user
									LIMIT 1";
		$db->query($upd_qry);
	}

	$_SESSION['region'] = $region;
	$target = '/page/regions/'.$region.'/';
  $_SESSION['validation'] = '';
} else{}

$_SESSION['error'] = $error

 ?>
