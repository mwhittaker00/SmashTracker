<?php

// Make sure this user is logged in and a mod
if ( !isset($_SESSION['logged']) || $_SESSION['logged'] != 1
			||  !isset($_SESSION['user_level']) || $_SESSION['user_level'] <= 2
	){
		$_SESSION['error'] = "You do not have permission to view that page.";
		simFail();

}

$char_qry = "SELECT char_id, char_displayName, char_fileName, game_id FROM characters";
$char_res = $db->query($char_qry);

$PMchars = '';
$MeleeChars = '';
$Sm4shChars = '';
$rivalChars = '';
$characterList = '';
while($row = $char_res->fetch_assoc()){

	if ( $row['game_id'] == 2 ){
		$divImg = "<a href='#'><img class='char-select img-thumbnail' attr-game='melee' attr-id='".$row['char_id']."' alt='".$row['char_displayName']."' src='/resources/images/melee/chars/".$row['char_fileName']."' /> </a>";
		$MeleeChars = $MeleeChars.$divImg;
	}
	else if ( $row['game_id'] == 3 ){
		$divImg = "<a href='#'><img class='char-select img-thumbnail' attr-game='pm' attr-id='".$row['char_id']."' alt='".$row['char_displayName']."' src='/resources/images/pm/chars/".$row['char_fileName']."' /> </a>";$PMchars = $PMchars.$divImg;
	}
	else if ( $row['game_id'] == 5 ){
		$divImg = "<a href='#'><img class='sm4sh-char char-select img-thumbnail' attr-game='smash4' attr-id='".$row['char_id']."' alt='".$row['char_displayName']."' src='/resources/images/smash4/chars/".$row['char_fileName']."' /> </a>";
		$Sm4shChars = $Sm4shChars.$divImg;
	}
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

$pageTitle = "Add a Player";
?>
