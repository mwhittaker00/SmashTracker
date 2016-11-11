<?php

$player_qry = "SELECT DISTINCT(a.user_id), user_name, user_affiliation,
								user_bio, region_name, regions.region_id, set_key
 							FROM user a
							JOIN user_region
								ON user_region.user_id = a.user_id
							JOIN regions
								ON user_region.region_id = regions.region_id
               LEFT JOIN sets s
              	ON s.set_id = (
									SELECT MAX(inn.set_id)
									FROM sets AS inn
									WHERE inn.user_id = a.user_id
							)
              WHERE set_key
              OR LENGTH(user_bio) > 0
              ORDER BY RAND()
              LIMIT 5";

$player_res = $db->query($player_qry);
$player_cnt = $player_res->num_rows;

$match_qry = "SELECT COUNT(matches.match_id) counter, game_name
									FROM matches
									JOIN game
									ON game.game_id = matches.game_id
									GROUP BY matches.game_id
									ORDER BY counter DESC";
$match_res = $db->query($match_qry);

$char_qry = "SELECT COUNT(user_characters.char_id) counter, characters.char_id,
										char_displayName, char_fileName, characters.game_id
           FROM characters
           JOIN user_characters
           ON characters.char_id = user_characters.char_id
           JOIN game
           ON characters.game_id = game.game_id
           WHERE is_main = 1
           GROUP BY characters.char_id
           ORDER BY counter DESC";
$char_res = $db->query($char_qry);

$gameArray = [];
$charData = [];
$i=0;
while ( $row = $char_res->fetch_assoc() ){
	$game = $row['game_id'];
	if ( !in_array($game, $gameArray) ){
		$filepath = '/resources/images/';
		if ( $game == 1 ){
			$filepath = $filepath.'64/';
		}
		else if ( $game == 2 ){
			$filepath = $filepath.'melee/';
		}
		else if ( $game == 3 ){
			$filepath = $filepath.'pm/';
		}
		else if ( $game == 4 ){
			$filepath = $filepath.'brawl/';
		}
		else if ( $game >= 5 ){
			$filepath = $filepath.'smash4/';
		}
		$filepath = $filepath.'chars/'.$row['char_fileName'];
		$gameArray[] = $row['game_id'];
		$charData[$i]['count'] = $row['counter'];
		$charData[$i]['fileName'] = $filepath;
		$charData[$i]['displayName'] = $row['char_displayName'];
		$i++;
	}
	else{}
}

?>
