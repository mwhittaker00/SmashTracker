<?php
$_PATH = $_SERVER['DOCUMENT_ROOT'];

if ( isset($_GET['var']) ){

	$regionId = $_GET['var'];
	if ( !ctype_digit($regionId) ){
		simFail();
	} else{}

	$user_qry = "SELECT DISTINCT user.user_name, user.user_id,
					ranking.score, game.game_name
								FROM user
								JOIN ranking
									ON user.user_id = ranking.user_id
								JOIN game
									ON ranking.game_id = game.game_id
								JOIN user_region
											ON user.user_id = user_region.user_id
										JOIN regions
											ON user_region.region_id = regions.region_id
								WHERE game.game_id IN (
										SELECT matches.game_id FROM matches
											WHERE matches.user_id_1 = user.user_id
												OR matches.user_id_2 = user.user_id)
								AND user.user_name NOT LIKE 'Test%'
								AND regions.region_id = $regionId
								ORDER BY game.game_name, ranking.score DESC";

	$user_res = $db->query($user_qry);

	$region_qry = "SELECT region_name, region_bio
					FROM regions
					WHERE region_id = $regionId LIMIT 1";
	$region_res = $db->query($region_qry);

	$region_row = mysqli_fetch_assoc($region_res);
	$region = htmlentities($region_row['region_name']);
	$regionBio = nl2br(htmlentities($region_row['region_bio']));

// Get the TOs / mods for this region
	$to_qry = "SELECT user.user_id, user_name
								FROM user
								JOIN user_region
									ON user_region.user_id = user.user_id
								WHERE user_level = 3
								AND region_id = $regionId";
	$to_res = $db->query($to_qry);

// Players for player list
	$player_qry = "SELECT user.user_id, user_name
								FROM user
								JOIN user_region
									ON user_region.user_id = user.user_id
								AND region_id = $regionId
	              ORDER BY user_name ASC, LENGTH(user_bio) DESC";
	$player_res = $db->query($player_qry);

// Get up to 5 random sets for this region
	$set_qry = "SELECT set_key, user_name, user.user_id
								FROM sets
								JOIN user_region
									ON user_region.user_id = sets.user_id
								JOIN user
									ON user.user_id = sets.user_id
								WHERE region_id = $regionId ORDER BY RAND() LIMIT 5";
	$set_res = $db->query($set_qry);

	// Create the "Edit Region" button if viewer is a mod of the current region.
	 if ( isMod() && isSameRegion($regionId) ){
		 $form = "<a href='/page/regions/edit/' class='btn btn-default edit-player-btn' />Edit Region</a>";
	 }
	 else{
		 $form = '';
	 }
}
else{
	$region = '';
}
?>
