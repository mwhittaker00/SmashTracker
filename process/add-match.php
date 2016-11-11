<?php
  $_PATH =  $_SERVER['DOCUMENT_ROOT'];
  require_once($_PATH.'/functions/init.func.php');

  $player1val = mysqli_real_escape_string($db, $_POST['player1']);
  $player2val = mysqli_real_escape_string($db, $_POST['player2']);
  $game = mysqli_real_escape_string($db, $_POST['game']);
  $winner = mysqli_real_escape_string($db, $_POST['winner']);

  $loser;

// Player A will bet he winner
// Player B will be the loser

  if ($winner === $player1val){
    $loser = $player2val;
  }
  else{
    $loser = $player1val;
  }

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

  echo "<div id='winner'><label>".htmlentities($userA)."</label> : New Score - ".htmlentities($Rna)."</div><div id='loser'><label>".htmlentities($userB)."</label> : New Score - ".htmlentities($Rnb)."</div>";

//print_r($_POST);
?>
