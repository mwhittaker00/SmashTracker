<?php
// Check if user is logged in and a valid level to operate this page.
if ( !isset($_SESSION['logged']) || $_SESSION['logged'] != 1
			||  !isset($_SESSION['user_level']) || $_SESSION['user_level'] <= 2
	){
		$_SESSION['error'] = "You do not have permission to access that page.";
	header('location:/page/fail/');

}
else{
	$region = $_SESSION['region'];
	$user_level = $_SESSION['user_level'];
	$userID = $_SESSION ['user'];
}

$user_qry = "SELECT user.user_id, user_name
							FROM user
							JOIN user_region
								ON user.user_id = user_region.user_id
							WHERE region_id = $region
							ORDER BY user_name ASC";
$user_res = $db->query($user_qry);

$game_qry = "SELECT game_id, game_name
 							FROM game
							WHERE game_id != 6
							ORDER BY game_name ASC";
$game_res = $db->query($game_qry);

$gamesList = '';

while($row = $game_res->fetch_assoc()){
		$gameID = htmlentities($row['game_id']);
		$gameName = htmlentities($row['game_name']);
		$gamesList = $gamesList."<option value='".$gameID."'>".$gameName."</option>";
	}

$pageTitle = "Add Matches";

?>
