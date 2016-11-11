<?php
if (isset($_GET['var'])){
	$playerID = $_GET['var'];
	if ( !ctype_digit($playerID) ){
		simFail();
	} else{}
}
else{
	$playerID = rand(10,50);
	// $username = "Find a Player";
}

$char_qry = "SELECT char_displayName, char_fileName, is_main, game_id
								FROM characters
								JOIN user_characters
									ON user_characters.char_id = characters.char_id
								WHERE user_characters.user_id = $playerID
								ORDER BY is_main DESC";
$char_res = $db->query($char_qry);

// Build character display html

$PMchars = '';
$MeleeChars = '';
$Sm4shChars = '';
$rivalChars = '';
$characterList = '';
while($row = $char_res->fetch_assoc()){
	$class = '';
	if ( $row['is_main'] == 1 ){
		$class='isMain';
	}
	else{
		$class='subChar';
	}

	if ( $row['game_id'] == 2 ){
		$divImg = "<img class='".$class." img-thumbnail' attr-game='melee' alt='".$row['char_displayName']."' src='/resources/images/melee/chars/".$row['char_fileName']."' />";
		$MeleeChars = $MeleeChars.$divImg;
	}
	else if ( $row['game_id'] == 3 ){
		$divImg = "<img class='".$class." img-thumbnail' attr-game='pm' alt='".$row['char_displayName']."' src='/resources/images/pm/chars/".$row['char_fileName']."' />";
		$PMchars = $PMchars.$divImg;
	}
	else if ( $row['game_id'] == 5 ){
		$divImg = "<img class='".$class." sm4sh-char img-thumbnail' attr-game='smash4' alt='".$row['char_displayName']."' src='/resources/images/smash4/chars/".$row['char_fileName']."' />";
		$Sm4shChars = $Sm4shChars.$divImg;
	}
	else if ( $row['game_id'] == 0 ){
		$divImg = "<img class='".$class." rivals-char img-thumbnail' attr-game='rivals' alt='".$row['char_displayName']."' src='/resources/images/rivals/chars/".$row['char_fileName']."' />";
		$rivalChars = $rivalChars.$divImg;
	}
}
$MeleeChars = "<div class='row'>".$MeleeChars."</div>";
$PMchars = "<div class='row'>".$PMchars."</div>";
$Sm4shChars = "<div class='row'>".$Sm4shChars."</div>";
$rivalChars = "<div class='row'>".$rivalChars."</div>";
$characters = $MeleeChars.$PMchars.$Sm4shChars.$rivalChars;

// Basic User Information
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

$placings = nl2br(htmlentities($user_row['user_placings']));
$bio = nl2br(htmlentities($user_row['user_bio']));
$region = htmlentities($user_row['region_name']);
$regionID = htmlentities($user_row['region_id']);

if ( strlen($placings) > 0 ){
	$placings = "<h4>Notable Placings</h4>".$placings;
}
if ( strlen($aff) > 0 ){
	$aff = $aff." | ";
} else{}


// Bracket victories uploaded from Challonge
$chal_qry = "SELECT bracket_name
								FROM bracket
								JOIN bracket_user
									ON bracket_user.bracket_id = bracket.bracket_id
								WHERE bracket_user.user_id = $playerID
								ORDER BY bracket.bracket_id DESC LIMIT 10";
$chal_res = $db->query($chal_qry);


// Sets uploaded for this player
$setQry = "SELECT set_id, set_key FROM sets
						WHERE user_id = $playerID LIMIT 3";
$set_res = $db->query($setQry);

// Get players records per game
$rec_qry = "SELECT a.game_id, game_name, COUNT(a.user_id_1) AS 'w',
							(
								( SELECT COUNT(b.match_id) FROM matches b WHERE
						     	(b.user_id_1 = $playerID OR b.user_id_2 =  $playerID)
						    	AND b.game_id = a.game_id
								) - COUNT(a.user_id_1)
							) AS 'l'
							FROM matches a
							JOIN game
							ON game.game_id = a.game_id
							WHERE a.user_id_1 =  $playerID
							GROUP BY game_name";
$rec_res = $db->query($rec_qry);

// Get Player's head-to-head data
$h2h_qry = "SELECT COUNT(a.match_id), user_id, user_name, game_name,
	( SELECT COUNT(b.match_id) FROM matches b
     	WHERE ( b.user_id_1 = $playerID OR b.user_id_2 = $playerID )
     	AND ( b.user_id_2 = a.user_id_1 OR b.user_id_2 = a.user_id_2)
     	AND b.user_id_1= $playerID
    	AND b.game_id = a.game_id) AS 'w',

     ( SELECT COUNT(c.match_id) FROM matches c
     	WHERE ( c.user_id_1 = $playerID OR c.user_id_2 = $playerID )
     	AND ( c.user_id_1 = a.user_id_1 OR c.user_id_1 = a.user_id_2)
     	AND c.user_id_1 != $playerID
    	AND c.game_id = a.game_id) AS 'l'


						FROM matches a
					    JOIN user
					      ON user.user_id = a.user_id_1
                          OR user.user_id = a.user_id_2
					    JOIN game
					      ON a.game_id = game.game_id
     WHERE (user_id_1 = $playerID
     	OR user_id_2 = $playerID)
      AND user.user_id != $playerID
     GROUP BY game_name, user_name
		 ORDER BY w DESC";

	$h2h_res = $db->query($h2h_qry);

// Generate HTML of h2h data
	$meleeCol = "<div class='col-md-3'><span class='h4'>Melee</span><br />";
	$pmCol = "<div class='col-md-3'><span class='h4'>Project M</span><br />";
	$smash4Col = "<div class='col-md-3'><span class='h4'>Smash 4</span><br />";
	$rivalsCol = "<div class='col-md-3'><span class='h4'>Rivals of Aether</span><br />";
	$h2h;

	while ( $row = $h2h_res->fetch_assoc() ){

		$newRow = "<a href='/page/players/".$row['user_id']."/'>".$row['user_name']."</a> - ".$row['w']."/".$row['l']." (".($row['w']-$row['l']).")<br />";

		if ( $row['game_name'] == 'Project M' ){
			$pmCol = $pmCol.$newRow;
		}
		elseif ( $row['game_name'] == 'Melee' ){
			$meleeCol = $meleeCol.$newRow;
		}
		elseif ( $row['game_name'] == 'Smash Wii U' ){
			$smash4Col = $smash4Col.$newRow;
		}
		elseif ( $row['game_name'] == 'Rivals of Aether' ){
			$rivalsCol = $rivalsCol.$newRow;
		}
	}

	$h2h = $meleeCol."</div>";
	$h2h = $h2h.$pmCol."</div>";
	$h2h = $h2h.$smash4Col."</div>";
	$h2h = $h2h.$rivalsCol."</div>";

// End h2h HTML

	if ( isMod() && isSameRegion($regionID) ){
		$formStart = "<form action='/players/editplayer/' method='post'>";
		$formContent = "<input type='hidden' name='region' value='".$regionID."' required /><input type='hidden' name='player' value='".$playerID."' required /><input type='hidden' name='referer' value='".$_uri."' />";
		$formClose = "<input type='submit' value='Edit Player' class='btn btn-default edit-player-btn' /></form>";
		$form = $formStart.$formContent.$formClose;
	}
	else{
		$form = '';
	}

// Collect and store data for flot chart
	$scores_qry = "SELECT CASE
											WHEN matches.user_id_1 = $playerID
												THEN matches.user_1_score
											WHEN matches.user_id_2 = $playerID
												THEN matches.user_2_score
										END AS player_score, game.game_name
										FROM matches
										JOIN game
											ON matches.game_id = game.game_id
										WHERE
											(user_id_1 = $playerID OR user_id_2 = $playerID)

										ORDER BY match_id, game_name ASC";

	$scores_res = $db->query($scores_qry);

		$data64[] = array(0,1500);
		$ct64 = 1;
		$dataMelee[] = array(0,1500);
		$ctMelee = 1;
		$dataBrawl[] = array(0,1500);
		$ctBrawl = 1;
		$dataPM[] = array(0,1500);
		$ctPM = 1;
		$data3DS[] = array(0,1500);
		$ct3DS = 1;
		$dataSm4[] = array(0,1500);
		$ctSm4 = 1;
		$dataRivals[] = array(0,1500);
		$ctRivals = 1;

		$curGame;
		$prevGame;
		$pass = 0;
		while ($row = $scores_res->fetch_assoc()){
			$curGame = $row['game_name'];

			if ($curGame === 'Project M'){
				$dataPM[] = array($ctPM, $row['player_score']);
				$ctPM++;
			}
			else if ($curGame === 'Melee'){
				$dataMelee[] = array($ctMelee, $row['player_score']);
				$ctMelee++;
			}
			else if ($curGame === 'Smash Wii U'){
				$dataSm4[] = array($ctSm4, $row['player_score']);
				$ctSm4++;
			}
			else if ($curGame === 'Rivals of Aether'){
				$dataRivals[] = array($ctRivals, $row['player_score']);
				$ctRivals++;
			}
			$prevGame = $curGame;
	}

?>
