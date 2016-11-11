<?php
  $region = $_SESSION['region'];
  $user = mysqli_real_escape_string($db, $_POST['name']);
  $playerID = mysqli_real_escape_string($db, $_POST['playerID']);
  $affiliate = mysqli_real_escape_string($db, $_POST['affiliate']);
  $bio = mysqli_real_escape_string($db, $_POST['bio']);
  $placings = mysqli_real_escape_string($db, $_POST['placings']);
  $set1 = mysqli_real_escape_string($db, $_POST['set1']);
  $set2 = mysqli_real_escape_string($db, $_POST['set2']);
  $set3 = mysqli_real_escape_string($db, $_POST['set3']);

// Check if characters were in all fields. If not, set to blank.
  if ( isset($_POST['meleeCharMain']) ){
    $meleeCharMain = mysqli_real_escape_string($db, $_POST['meleeCharMain']);
  } else{
    $meleeCharMain = 0;
  }
  if ( isset($_POST['meleeChar2']) ){
    $meleeChar2 = mysqli_real_escape_string($db, $_POST['meleeChar2']);
  } else{
    $meleeChar2 = 0;
  }
  if ( isset($_POST['meleeChar3']) ){
    $meleeChar3 = mysqli_real_escape_string($db, $_POST['meleeChar3']);
  } else{
    $meleeChar3 = 0;
  }
  if ( isset($_POST['pmCharMain']) ){
    $pmCharMain = mysqli_real_escape_string($db, $_POST['pmCharMain']);
  } else{
    $pmCharMain = 0;
  }
  if ( isset($_POST['pmChar2']) ){
    $pmChar2 = mysqli_real_escape_string($db, $_POST['pmChar2']);
  } else{
    $pmChar2 = 0;
  }
  if ( isset($_POST['pmChar3']) ){
    $pmChar3 = mysqli_real_escape_string($db, $_POST['pmChar3']);
  } else{
    $pmChar3 = 0;
  }
  if ( isset($_POST['smash4CharMain']) ){
    $smash4CharMain = mysqli_real_escape_string($db, $_POST['smash4CharMain']);
  } else{
    $smash4CharMain = 0;
  }
  if ( isset($_POST['smash4Char2']) ){
    $smash4Char2 = mysqli_real_escape_string($db, $_POST['smash4Char2']);
  } else{
    $smash4Char2 = 0;
  }
  if ( isset($_POST['smash4Char3']) ){
    $smash4Char3 = mysqli_real_escape_string($db, $_POST['smash4Char3']);
  } else{
    $smash4Char3 = 0;
  }

  if ( isset($_POST['rivalsCharMain']) ){
    $rivalsCharMain = mysqli_real_escape_string($db, $_POST['rivalsCharMain']);
  } else{
    $rivalsCharMain = 0;
  }
  if ( isset($_POST['rivalsChar2']) ){
    $rivalsChar2 = mysqli_real_escape_string($db, $_POST['rivalsChar2']);
  } else{
    $rivalsChar2 = 0;
  }
  if ( isset($_POST['rivalsChar3']) ){
    $rivalsChar3 = mysqli_real_escape_string($db, $_POST['rivalsChar3']);
  } else{
    $rivalsChar3 = 0;
  }

  $date = date("Y-m-d");

// Check for empty user field, or empty SESSION variable
  if ( empty($user) || empty($region) ){
    $success = 'false';
    $_SESSION['error'] = "Please provide a name for this player.";
    $target = '/players/editplayer/';
  	return;
  }

  // Validate POST data exists in database. Do we have a single entry for
  // // this player in the user_region table with the mod's region?
  $valid_qry = "SELECT region_id FROM user_region
  							WHERE region_id = $region AND user_id = $playerID";
  $valid_res = $db->query($valid_qry);
  $valid_cnt = $valid_res->num_rows;

  if ($valid_cnt != 1){
    $_SESSION['error'] = "We were unable to process your request.";
    $success = 'false';
  	$target = '/page/fail/';
  }
// Check if user name is in use for this region
  $check_qry = "SELECT user_region.user_id, user_region.region_id
                  FROM user
                  JOIN user_region
                    ON user.user_id = user_region.user_id
                  WHERE user_name = '$user'
                  AND user.user_id != $playerID
                  AND region_id = $region LIMIT 1";
  $check_res = $db->query($check_qry);
  $user_cnt = $check_res->num_rows;

  if ($user_cnt > 0){
    $_SESSION['error'] = $user." is already registered.";
    $success = 'false';
  }
  if ( $success !== 'false' ){
    $success = 'true';

// Update USER table
    $user_upd_qry = "UPDATE user
                      SET user_name = '$user',
                        user_affiliation = '$affiliate',
                        user_placings = '$placings',
                        user_bio = '$bio'
                      WHERE user_id = $playerID
                      LIMIT 1";
    $db->query($user_upd_qry);


// Add Sets

// // First clear sets for this player
    $set_del_qry = "DELETE FROM sets WHERE user_id = $playerID";
    $db->query($set_del_qry);

// // Now add the entered sets
    $setQry = "INSERT INTO sets
              (user_id, set_key)
            VALUES
              ('$playerID','$set1'),
              ('$playerID','$set2'),
              ('$playerID','$set3')";
    $db->query($setQry);

// // Remove blank entries
    $setDel = "DELETE FROM sets WHERE set_key = ''";
    $db->query($setDel);

// Add Characters

// // First clear characters for this player
    $chr_del_qry = "DELETE FROM user_characters WHERE user_id = $playerID";
    $db->query($chr_del_qry);

// // Now add entered characters
    $chrQry = "INSERT INTO user_characters
              (user_id, char_id, is_main)
            VALUES
              ('$playerID','$meleeCharMain',1),
              ('$playerID','$meleeChar2',0),
              ('$playerID','$meleeChar3',0),
              ('$playerID','$pmCharMain',1),
              ('$playerID','$pmChar2',0),
              ('$playerID','$pmChar3',0),
              ('$playerID','$smash4CharMain',1),
              ('$playerID','$smash4Char2',0),
              ('$playerID','$smash4Char3',0),
              ('$playerID','$rivalsCharMain',1),
              ('$playerID','$rivalsChar2',0),
              ('$playerID','$rivalsChar3',0)";
    $db->query($chrQry);

// // Remove blank entries
    $chrDel = "DELETE FROM user_characters WHERE char_id = 0";
    $db->query($chrDel);

// Go to player's profile
  $target = "/page/players/".$playerID."/";
}
?>
