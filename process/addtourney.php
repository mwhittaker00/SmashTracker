<?php
  $challongeKey = 'QhAAhYpTRpjeyEcnQ8YIvG3ytHPQCncMopjvhruQ';

  if ( !empty($_POST['bracketsub']) ){
    $bracketSub = mysqli_real_escape_string($db, $_POST['bracketsub'])."-";
  }
  else{
    $bracketSub = '';
  }
  $challongeURL = $bracketSub.mysqli_real_escape_string($db, $_POST['bracketurl']);
	$referer = mysqli_real_escape_string($db, $_POST['referer']);
  $game = mysqli_real_escape_string($db, $_POST['game']);
  $regionID = $_SESSION['region'];
  $submitted_by = $_SESSION['user'];
  $user_level = $_SESSION['user_level'];
  $target = $referer;
  $success = '';

// Does this URL exist in the DB already?
$qry = "SELECT bracket.bracket_id
        FROM bracket
				JOIN bracket_region
					ON bracket_region.bracket_id = bracket.bracket_id
        WHERE bracket_url = '$challongeURL'
				AND region_id = $regionID
        LIMIT 1";

$qry_res = $db->query($qry);
$bracket_cnt = $qry_res->num_rows;


if ($bracket_cnt >= 1){
  // This URL is in the DB. Fail out.
  $success = 'false';
  $_SESSION['error'] = 'This bracket has already been submitted.';
}
else{

// CHECK for status of request ( 404, etc ) and process accordingly.

// Get the list of participants for the supplied bracket
  $jsonPeople = file_get_contents('https://rockySSB:'.$challongeKey.'@api.challonge.com/v1/tournaments/'.$challongeURL.'/participants.json');
// Name, ID, game, etc of bracket
  $jsonInfo = file_get_contents('https://rockySSB:'.$challongeKey.'@api.challonge.com/v1/tournaments/'.$challongeURL.'.json');
// Match data for bracket
  $jsonMatch = file_get_contents('https://rockySSB:'.$challongeKey.'@api.challonge.com/v1/tournaments/'.$challongeURL.'/matches.json');

  $people = json_decode($jsonPeople);
  $info = json_decode($jsonInfo);
  $matches = json_decode($jsonMatch);
  $tourney = $info->tournament;

// Get the game_id for the game being played.

  $gameID = $game;
  $bracketName = $tourney->name;
  $bracketParticipants = $tourney->participants_count;

// Create array of Challonge ID => Challonge Name
  $sets = [];
  $winners = [];
  foreach ( $people as $key){
    $person = $key->participant;
    $sets[$person->id] = trim(strtolower($person->name));
  }

// Find the players in this region
  $qry = "SELECT user_name, user.user_id
            FROM user
            JOIN user_region
    	         ON user_region.user_id = user.user_id
            WHERE region_id = $regionID";
  $res = $db->query($qry);
  $users = [];

  while ( $row = $res->fetch_assoc()){
    array_push($users,strtolower($row['user_name']));
  }
// Find out who won and lost each match. Create array of winners so we can get rankings.
  $set = [];
  $no = [];
  $i = 0;
  foreach ( $matches as $key){
    $match = $key->match;
    $winner = $sets[$match->winner_id];
    $loser = $sets[$match->loser_id];

    if ( in_array($winner,$users) && in_array($loser,$users) ){
      addMatch($db,$winner,$loser,$gameID,$regionID);
    } else{}

    array_push($winners,$winner);
    $i++;
  }

// Get ID for bracket winner, make sure they're in the same region as the submitter
  $tourneyWinner = end($winners);
  $qry = "SELECT user_name, user.user_id
            FROM user
            JOIN user_region
               ON user_region.user_id = user.user_id
            WHERE region_id = $regionID
            AND LOWER(user_name) = '$tourneyWinner' LIMIT 1";
  $res = $db->query($qry);

  $row = mysqli_fetch_assoc($res);
  $winnerID = $row['user_id'];

// see if the players **IN THE BRACKET** are in the same region as the current user

// Break winners array into SQL friendly string for IN check
    $i = 0;
    $len = count($winners);
    $in = '';
    foreach ( $winners as $item ){
      $player = mysqli_real_escape_string($db,$item);
      if ( $i == $len - 1 ){
        $in = $in."'".$player."'";
      }
      else{
        $in = $in."'".$player."',";
      }
      $i++;
    }

  	$qry = "SELECT user_name, user.user_id
              FROM user
              JOIN user_region
                 ON user_region.user_id = user.user_id
              WHERE region_id = $regionID
              AND LOWER(user_name) IN ( $in )";

    $res = $db->query($qry);

  	if ( $res->num_rows >= 1 ){
  		echo "Same region";
  	}

// If they're in the same region, move forward with inserts and updates
	if ( $res->num_rows >= 1 ){

	// Insert into BRACKET table
	  $ins_qry = "INSERT INTO bracket
	                (bracket_name,bracket_url,bracket_subdomain,bracket_participants)
	              VALUES
	                ('$bracketName','$challongeURL','$bracketSub','$bracketParticipants')";
	  $db->query($ins_qry);
	  $bracketID = $db->insert_id;

	// Insert user-bracket link for the winner.
    if ( !empty($winnerID) ){
  	  $ins2_qry = "INSERT INTO bracket_user
  	                (bracket_id, user_id)
  	              VALUES
  	                ($bracketID,$winnerID)";
  	  $db->query($ins2_qry);
    }
    else{
      $_SESSION['error'] = "We couldn't find the bracket winner in your player database.";
    }
	// Insert bracket-region link
	  $ins3_qry = "INSERT INTO bracket_region
	                (bracket_id, region_id)
	              VALUES
	                ($bracketID,$regionID)";
	  $db->query($ins3_qry);
	// Insert bracket-game link
	  $ins3_qry = "INSERT INTO bracket_game
	                (bracket_id, game_id)
	              VALUES
	                ($bracketID, $gameID)";
	  $db->query($ins3_qry);

	  $success = 'true';
	  $_SESSION['success'] = "The bracket '".$bracketName."' has been successfully submitted.";
	}
  else{
    // ELSE the winner was not in the region, so the bracket must not belong to the region
      $_SESSION['error'] = 'It looks like you tried to submit a bracket for another region.';
      $success = 'false';
  }

}

  function addMatch($db,$winnerName,$loserName,$game,$region){

    $qry1 = "SELECT user_name, user.user_id
              FROM user
              JOIN user_region
      	         ON user_region.user_id = user.user_id
              WHERE region_id = $region
              AND LOWER(user_name) = '$winnerName' LIMIT 1";
    $res1 = $db->query($qry1);

    $row1 = mysqli_fetch_assoc($res1);
    $winner = $row1['user_id'];

    $qry2 = "SELECT user_name, user.user_id
              FROM user
              JOIN user_region
      	         ON user_region.user_id = user.user_id
              WHERE region_id = $region
              AND LOWER(user_name) = '$loserName' LIMIT 1";
    $res2 = $db->query($qry2);

    $row2 = mysqli_fetch_assoc($res2);
    $loser = $row2['user_id'];

    // Get Current Ratings
      $Ra;
      $Rb;

      $score_qry = "SELECT score FROM ranking
                    WHERE user_id = $winner
                    AND game_id = $game
                    LIMIT 1";
      $score_res = $db->query($score_qry);
      $scoreA = $score_res->fetch_assoc();
      $Ra = $scoreA['score'];

      $score_qry = "SELECT score FROM ranking
                    WHERE user_id = $loser
                    AND game_id = $game
                    LIMIT 1";
      $score_res = $db->query($score_qry);
      $scoreB = $score_res->fetch_assoc();
      $Rb = $scoreB['score'];

    //weight
      $K = 15;
    //Win chance
      $Ea;
      $Eb;
    //New Ratings
      $Rna;
      $Rnb;

    // Get the chance of winning
      $Ea = 1/(1+pow(10,(($Rb-$Ra)/400)));
      $Eb = 1/(1+pow(10,(($Ra-$Rb)/400)));

    // Get the updated scores
      $Rna = round($Ra + 15*(1-$Ea));
      $Rnb = round($Rb + 15*(0-$Eb));

      if($Rnb < 1200){
        $Rnb = 1200;
      }


    // Update the database
      $upd_qry = "UPDATE ranking
                    SET score = $Rna
                    WHERE user_id = $winner
                    AND game_id = $game LIMIT 1";
      $db->query($upd_qry);

      $upd_qry = "UPDATE ranking
                    SET score = $Rnb
                    WHERE user_id = $loser
                    AND game_id = $game LIMIT 1";
      $db->query($upd_qry);


    // Insert match into records
      $ins_qry = "INSERT INTO matches
      		    (user_id_1, user_id_2, user_1_score, user_2_score, game_id)
                    VALUES
                        ($winner, $loser, $Rna, $Rnb, $game)";
      $db->query($ins_qry);

    // Prepare return values

      $user_qry = "SELECT user_name FROM user
                    WHERE user_id = $winner LIMIT 1";
      $user_res = $db->query($user_qry);
      $userA = $user_res->fetch_assoc();
      $userA = $userA['user_name'];

      $user_qry = "SELECT user_name FROM user
                    WHERE user_id = $loser LIMIT 1";
      $user_res = $db->query($user_qry);
      $userB = $user_res->fetch_assoc();
      $userB = $userB['user_name'];
  }
?>
