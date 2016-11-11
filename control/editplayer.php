<?php

$regionID = mysqli_real_escape_string($db, $_POST['region']);
$playerID = mysqli_real_escape_string($db, $_POST['player']);
$referer = mysqli_real_escape_string($db, $_POST['referer']);

$userRegion = $_SESSION['region'];
$userID = $_SESSION['user'];

// Check if user is logged in and a valid level to operate this page.
// isLogged() and isSameRegion() and isMod()
if ( !isset($_SESSION['logged']) || $_SESSION['logged'] != 1
			||  !isset($_SESSION['user_level']) || $_SESSION['user_level'] <= 2
	){
    $_SESSION['error'] = "You do not have permission to edit that profile.";
    header('location:/page/fail/');

}

// Validate POST data exists in database. Do we have a single entry for this player in the user_region table?
$valid_qry = "SELECT region_id FROM user_region
							WHERE region_id = $regionID AND user_id = $playerID";
$valid_res = $db->query($valid_qry);
$valid_cnt = $valid_res->num_rows;

if ($valid_cnt != 1){
  $_SESSION['error'] = "Something went wrong. Are you sure you were supposed to do that?";
	header('location:/page/fail/');
}

// If this mod is not in the players's region, kick them out
if ($regionID != $userRegion){
  $_SESSION['error'] = "You do not have permission to edit that profile.";
	header('location:/page/fail/');
}else{}

// Select all of the characters and portraits
$charList_qry = "SELECT char_id, char_displayName, char_fileName, game_id FROM characters";
$charList_res = $db->query($charList_qry);

// Select this player's characters
$char_qry = "SELECT char_displayName, char_fileName, is_main, characters.char_id, game_id

								FROM characters
								JOIN user_characters
									ON user_characters.char_id = characters.char_id
								WHERE user_characters.user_id = $playerID
								ORDER BY is_main DESC LIMIT 9";
$char_res = $db->query($char_qry);

// Select profile information for this player
$user_qry = "SELECT user_name, user_affiliation, user_placings,
										user_bio, region_name, regions.region_id
 							FROM user
							JOIN user_region
								ON user_region.user_id = user.user_id
							JOIN regions
								ON user_region.region_id = regions.region_id
							WHERE user.user_id = $playerID LIMIT 1";
$user_res = $db->query($user_qry);

$user_row = mysqli_fetch_assoc($user_res);
$username = htmlentities($user_row['user_name']);
$aff = htmlentities($user_row['user_affiliation']);

$placings = htmlentities($user_row['user_placings']);
$bio = htmlentities($user_row['user_bio']);
$region = htmlentities($user_row['region_name']);
$regionID = htmlentities($user_row['region_id']);

// Select the sets for this player
$setQry = "SELECT set_id, set_key FROM sets
						WHERE user_id = $playerID LIMIT 3";
$set_res = $db->query($setQry);

$sID = [];
$sKey = [];

	while ($row = $set_res->fetch_assoc()){
		array_push($sID,htmlentities($row['set_id']));
		array_push($sKey,htmlentities($row['set_key']));
	}

// HTML for ALL characters
	$PMchars = '';
	$MeleeChars = '';
	$Sm4shChars = '';
	$rivalChars = '';
	$characterList = '';
	while($row = $charList_res->fetch_assoc()){

	// if game is MELEE
		if ( $row['game_id'] == 2 ){
			$divImg = "<a href='#'><img class='char-select img-thumbnail' attr-game='melee' attr-id='".$row['char_id']."' alt='".$row['char_displayName']."' src='/resources/images/melee/chars/".$row['char_fileName']."' /> </a>";
			$MeleeChars = $MeleeChars.$divImg;
		}
	// if game is PM
		else if ( $row['game_id'] == 3 ){
			$divImg = "<a href='#'><img class='char-select img-thumbnail' attr-game='pm' attr-id='".$row['char_id']."' alt='".$row['char_displayName']."' src='/resources/images/pm/chars/".$row['char_fileName']."' /> </a>";$PMchars = $PMchars.$divImg;
		}
	// if game is Smash 4
		else if ( $row['game_id'] == 5 ){
			$divImg = "<a href='#'><img class='sm4sh-char char-select img-thumbnail' attr-game='smash4' attr-id='".$row['char_id']."' alt='".$row['char_displayName']."' src='/resources/images/smash4/chars/".$row['char_fileName']."' /> </a>";
			$Sm4shChars = $Sm4shChars.$divImg;
		}
	// if game is Rivals of Aether
		else if ( $row['game_id'] == 0 ){
			$divImg = "<a href='#'><img class='rivals-char char-select img-thumbnail' attr-game='rivals' attr-id='".$row['char_id']."' alt='".$row['char_displayName']."' src='/resources/images/rivals/chars/".$row['char_fileName']."' /> </a>";
			$rivalChars = $rivalChars.$divImg;
		}
	}
	$MeleeChars = "<div class='char-select-section melee-char-select'>".$MeleeChars."</div>";
	$PMchars = "<div class='char-select-section pm-char-select'>".$PMchars."</div>";
	$Sm4shChars = "<div class='char-select-section smash4-char-select'>".$Sm4shChars."</div>";
	$rivalChars = "<div class='char-select-section rivals-char-select'>".$rivalChars."</div>";
	$characterList = $MeleeChars.$PMchars.$Sm4shChars.$rivalChars;

// HTML for THIS PLAYER'S SELECTED characters$i = 1;
	$selectedPM = "<div>";
	$PMi = 1;
	$selectedMelee = "<div>";
	$meleei = 1;
	$selectedSmash4 = "<div>";
	$smash4i = 1;
	$selectedRivals = "<div>";
	$rivalsi = 1;

	$selectedChars = '';
	$game = '';
	$gameClass = '';
	$hiddenCharForm = '';

	while($row = $char_res->fetch_assoc()){

		if ( $row['game_id'] == 2 ){
			$game = 'melee';
			$selectedMelee = $selectedMelee."<img class='melee-selected-".$meleei." img-thumbnail char-selected' src='/resources/images/melee/chars/".$row['char_fileName']."' alt='".$row['char_displayName']."' />";
			$i = $meleei;
			$meleei ++;
		}
		else if ( $row['game_id'] == 3 ){
			$game = 'pm';
			$selectedPM = $selectedPM."<img class='pm-selected-".$PMi." img-thumbnail char-selected' src='/resources/images/pm/chars/".$row['char_fileName']."' alt='".$row['char_displayName']."' />";
			$i = $PMi;
			$PMi ++;
		}
		else if ( $row['game_id'] == 5 ){
			$game = 'smash4';
			$selectedSmash4 = $selectedSmash4."<img class='sm4sh-char smash4-selected-".$smash4i." img-thumbnail char-selected' src='/resources/images/smash4/chars/".$row['char_fileName']."' alt='".$row['char_displayName']."' />";
			$i = $smash4i;
			$smash4i ++;
		}
		else if ( $row['game_id'] == 0 ){
			$game = 'rivals';
			$selectedRivals = $selectedRivals."<img class='rivals-char rivals-selected-".$rivalsi." img-thumbnail char-selected' src='/resources/images/rivals/chars/".$row['char_fileName']."' alt='".$row['char_displayName']."' />";
			$i = $rivalsi;
			$smash4i ++;
		}
		if ( $row['is_main'] == 1 ){
			$fieldName = "name='".$game."CharMain'";
		} else{
			$fieldName = "name='".$game."Char".$i."'";
		}
		$hiddenCharForm = $hiddenCharForm."<input type='hidden' value='".$row['char_id']."' class='char-form char-main char-".$i."' ".$fieldName." />";

	}
	$selectedChars = $selectedChars.$selectedMelee."</div>";
	$selectedChars = $selectedChars.$selectedPM."</div>";
	$selectedChars = $selectedChars.$selectedSmash4."</div>";
	$selectedChars = $selectedChars.$selectedRivals."</div>";
	$selectedChars = "<div id='edit-selected-chars'>".$hiddenCharForm.$selectedChars."</div>";

	$pageTitle = "Edit | ".$username;
?>
