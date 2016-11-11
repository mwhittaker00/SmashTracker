<?php

$username = strtolower(mysqli_real_escape_string($db, $_POST['username']));
$password = mysqli_real_escape_string($db, $_POST['password']);

$qry = "SELECT user.user_id, user_name, user_password, region_id, user_level
				FROM user
				JOIN user_region
					ON user.user_id = user_region.user_id
					WHERE LOWER(user_name) = '$username'
					AND user_password = MD5(CONCAT('$password',user_dateJoined))
					LIMIT 1";

$qry_res = $db->query($qry);
$usr_cnt = $qry_res->num_rows;

if ($usr_cnt === 1){
	// user is logged in.
	$user = $qry_res->fetch_assoc();
	$id = $user['user_id'];
	$region = $user['region_id'];
	$user_level = $user['user_level'];

//
// Set USER cookie
//
	$c_name = 'user';
	$c_value = $username;
	setcookie($c_name,$c_value,time()+(86400 * 30), "/"); // 30 day cookie
	$_SESSION['logged'] = 1;
	$_SESSION['user'] = $id;
	$_SESSION['region'] = $region;
	$_SESSION['user_level'] = $user_level;

	if ( isMod() ){
		if ($region == 0){
			$target='/page/reg2/';
		}
		else{
			$target='/page/regions/'.$region.'/';
		}
	}

	$success = 'true';
}
else{
	// Make sure user isn't logged in somehow, prepare error message, and send back to log in page
	$_SESSION['logged'] = 0;
	$_SESSION['error'] = 'Wrong user name or password. Please try again.';
	$success = 'false';
}
?>
