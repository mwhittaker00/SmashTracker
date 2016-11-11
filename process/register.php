<?php

$error = "";
$success = "";

if ( !isset($_SESSION['reg_key']) ){
	simFail();
}
else{
	$key = $_SESSION['reg_key'];

	$key_qry = "SELECT reg_key_val, reg_key_activated FROM reg_key
	              WHERE reg_key_val = '$key'
	              LIMIT 1";
	$key_res = $db->query($key_qry);
	$key_cnt = $key_res->num_rows;
	$key_row = $key_res->fetch_assoc();

	if ( $key_cnt == 0 ){
	  $error = "Invalid registration code.";
	  $success = 'false';
	}
	else if ( $key_row['reg_key_activated'] == 1 ){
	  $error = 'This registration code has already been used.';
	  $success = 'false';
	}
}

$username = mysqli_real_escape_string($db, $_POST['username']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$remail = mysqli_real_escape_string($db, $_POST['remail']);
$password = mysqli_real_escape_string($db, $_POST['password']);
$repass = mysqli_real_escape_string($db, $_POST['repassword']);
$target = mysqli_real_escape_string($db, $_POST['target']);
$referer = mysqli_real_escape_string($db, $_POST['referer']);


if (empty($username) || empty($email) || empty($remail) || empty($password) ||
		empty($repass)){
			$error = "You left a field blank. Please try again.";
      $success = 'false';
		}
if ($email !== $remail || $password !== $repass){
			$error = "You did not enter matching email addresses or passwords. Please try again.";
      $success = 'false';
		}

if ( $success !== 'false' ){

  $qry = "SELECT user_name
  				FROM user
  					WHERE user_name = '$username'
  					LIMIT 1";
  $qry_res = $db->query($qry);
  $usr_cnt = $qry_res->num_rows;

  if ($usr_cnt >= 1){
  	$error = "This username already exists.";
    $success = 'false';
  }
}

if ( $success !== 'false' ){
  $success = 'true';
	$date = date("Y-m-d");
	$new_pass = MD5($password.$date);

	$ins_qry = "INSERT INTO user
								(user_name, user_email, user_password, user_activated, user_dateJoined, user_level)
							VALUES
								('$username', '$email', '$new_pass', 1, '$date', 3)";

	$db->query($ins_qry);
	$user = $db->insert_id;

	// INSERT a blank user_region region for the user
	$reg_qry = "INSERT INTO user_region
								(user_id, region_id)
							VALUES
								($user,0)";
	$db->query($reg_qry);

// Create RANKING for this user
	$rank_ins_qry = "INSERT INTO ranking
											(user_id, game_id)
										VALUES
										($user, 1),
										($user, 2),
										($user, 3),
										($user, 4),
										($user, 5),
										($user, 6)";
	$db->query($rank_ins_qry);

	$c_name = 'user';
	$c_value = $username;
	setcookie($c_name,$c_value,time()+(86400 * 30), "/"); // 30 day cookie
	$_SESSION['logged'] = 1;
	$_SESSION['user'] = $user;
	$_SESSION['user_level'] = 3;
  $_SESSION['region'] = 0;

///
// UPDATE KEY ACTIVATION VALUE> REMOVE AFTER BETA
///
	$key_upd = "UPDATE reg_key
								SET reg_key_activated = 1,
										user_id = $user
										WHERE reg_key_val = '$key' LIMIT 1";
	$db->query($key_upd);
}

else{
  $success = 'false';
}

$_SESSION['error'] = $error;
?>
