<?php

  $region = $_SESSION['region'];
  $user = mysqli_real_escape_string($db, $_POST['name']);
  $affiliate = mysqli_real_escape_string($db, $_POST['affiliate']);
  $bio = mysqli_real_escape_string($db, $_POST['bio']);
  $placings = mysqli_real_escape_string($db, $_POST['placings']);
  $set1 = mysqli_real_escape_string($db, $_POST['set1']);
  $set2 = mysqli_real_escape_string($db, $_POST['set2']);
  $set3 = mysqli_real_escape_string($db, $_POST['set3']);
  $meleeCharMain = mysqli_real_escape_string($db, $_POST['meleeCharMain']);
  $meleeChar2 = mysqli_real_escape_string($db, $_POST['meleeChar2']);
  $meleeChar3 = mysqli_real_escape_string($db, $_POST['meleeChar3']);
  $pmCharMain = mysqli_real_escape_string($db, $_POST['pmCharMain']);
  $pmChar2 = mysqli_real_escape_string($db, $_POST['pmChar2']);
  $pmChar3 = mysqli_real_escape_string($db, $_POST['pmChar3']);
  $smash4CharMain = mysqli_real_escape_string($db, $_POST['smash4CharMain']);
  $smash4Char2 = mysqli_real_escape_string($db, $_POST['smash4Char2']);
  $smash4Char3 = mysqli_real_escape_string($db, $_POST['smash4Char3']);
  $rivalsCharMain = mysqli_real_escape_string($db, $_POST['rivalsCharMain']);
  $rivalsChar2 = mysqli_real_escape_string($db, $_POST['rivalsChar2']);
  $rivalsChar3 = mysqli_real_escape_string($db, $_POST['rivalsChar3']);
  $date = date("Y-m-d");

// Check for empty user field, or empty SESSION variable
  if ( empty($user) || empty($region) ){
    $success = 'false';
    $_SESSION['error'] = "Please provide a name for this player.";
    $target = '/players/addplayer/';
		return;
  }

// Check if user name is in use
  $check_qry = "SELECT user_region.user_id, user_region.region_id
                  FROM user
                  JOIN user_region
                    ON user.user_id = user_region.user_id
                  WHERE user_name = '$user'
                  AND region_id = $region LIMIT 1";
  $check_res = $db->query($check_qry);
  $user_cnt = $check_res->num_rows;

// If the user already exists in this region, try again
  if ($user_cnt > 0){
    $success = 'false';
    $_SESSION['error'] = $user." is already registered in your region.";
    $target = '/players/addplayer/';
		return;
  }

	if ( $success !== 'false' ){
    $success = 'true';

// Add to USER table
    $user_ins_qry = "INSERT INTO user
                  (user_name, user_dateJoined, user_affiliation, user_placings, user_bio)
                VALUES
                  ('$user','$date','$affiliate','$placings','$bio')";
    $db->query($user_ins_qry);
    $user_id = $db->insert_id;

// Set default rank for each game
    $rank_ins_qry = "INSERT INTO ranking
                        (user_id, game_id)
                      VALUES
                      ($user_id, 0),
                      ($user_id, 1),
                      ($user_id, 2),
                      ($user_id, 3),
                      ($user_id, 4),
                      ($user_id, 5),
                      ($user_id, 6)";
    $db->query($rank_ins_qry);

// Set player to TO's region
  $reg_qry = "INSERT INTO user_region
                (user_id,region_id)
              VALUES
                ($user_id, $region)";
  $db->query($reg_qry);


// Add Sets
  $setQry = "INSERT INTO sets
              (user_id, set_key)
            VALUES
              ('$user_id','$set1'),
              ('$user_id','$set2'),
              ('$user_id','$set3')";
  $db->query($setQry);
  $setDel = "DELETE FROM sets WHERE set_key = ''";
  $db->query($setDel);

// Add Characters
  $chrQry = "INSERT INTO user_characters
              (user_id, char_id, is_main)
            VALUES
              ('$user_id','$meleeCharMain',1),
              ('$user_id','$meleeChar2',0),
              ('$user_id','$meleeChar3',0),
              ('$user_id','$pmCharMain',1),
              ('$user_id','$pmChar2',0),
              ('$user_id','$pmChar3',0),
              ('$user_id','$smash4CharMain',1),
              ('$user_id','$smash4Char2',0),
              ('$user_id','$smash4Char3',0),
              ('$user_id','$rivalsCharMain',1),
              ('$user_id','$rivalsChar2',0),
              ('$user_id','$rivalsChar3',0)";
  $db->query($chrQry);

// If they didn't supply extra characters, clean up any empty references
  $chrDel = "DELETE FROM user_characters WHERE char_id = 0";
  $db->query($chrDel);

  $target = "/page/players/".$user_id."/";
}
?>
