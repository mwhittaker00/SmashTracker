<?php
$_PATH = $_SERVER['DOCUMENT_ROOT'];

$regionId = $_SESSION['region'];

$region_qry = "SELECT region_name, region_bio
				FROM regions
				WHERE region_id = $regionId LIMIT 1";
$region_res = $db->query($region_qry);

$region_row = mysqli_fetch_assoc($region_res);
$region = htmlentities($region_row['region_name']);
$regionBio = htmlentities($region_row['region_bio']);

// Get the TOs / mods for this region
$to_qry = "SELECT user.user_id, user_name
							FROM user
							JOIN user_region
								ON user_region.user_id = user.user_id
							WHERE user_level = 3
							AND region_id = $regionId";
$to_res = $db->query($to_qry);

//Get ALL of the players for this region.
$player_qry = "SELECT user.user_id, user_name
							FROM user
							JOIN user_region
								ON user_region.user_id = user.user_id
							AND region_id = $regionId
              ORDER BY LENGTH(user_bio) DESC";
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

$title = 'Edit Region';
?>
