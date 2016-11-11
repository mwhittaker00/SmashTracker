<?php

// Select player info for right column features
$players_qry = "SELECT DISTINCT user.user_id, user_name, user_bio, user_affiliation,
												char_displayName, char_fileName, region_name, regions.region_id, game_name, game.game_id, bracket_game.game_id, bracket_user.bracket_id, bracket_name
									FROM user
									JOIN user_region
										ON user_region.user_id = user.user_id
									JOIN regions
										ON regions.region_id = user_region.region_id
									JOIN user_characters
										ON user_characters.user_id = user.user_id
									JOIN characters
										ON characters.char_id = user_characters.char_id
									JOIN bracket_user
										ON bracket_user.user_id = user.user_id
									JOIN bracket
										ON bracket.bracket_id = bracket_user.bracket_id
									JOIN bracket_game
										ON bracket.bracket_id = bracket_game.bracket_id
									JOIN game
										ON game.game_id = bracket_game.game_id
									AND is_main = 1
									AND characters.game_id = bracket_game.game_id
									ORDER BY bracket_user.bracket_id DESC LIMIT 10";

$players_res = $db->query($players_qry);

// Select 10 most recent articles.
$art_qry = "SELECT sub_id, sub_category, sub_type, sub_title,
									DATE_FORMAT(sub_date,'%b %d, %Y')  AS 'sub_date',
									sub_author, sub_description, sub_content
							FROM submissions
							ORDER BY sub_date ASC LIMIT 10";
$art_res = $db->query($art_qry);
$momImg = "<img class='article-image' src='/images/MoM1.png' alt='Mind Over Meta' />";
$intImg = "<img class='article-image' alt='Interview' src='./images/microphone_icon.png'>";
$weekImg = "<img class='article-image' alt='This Week in PM' src='./images/weekpm.jpg'>";

//
// Get most recent Facebook Page posts
//

$pageID = 'smashtracker';
$accessToken = '696948393773068|9b3c0f7a4bd17ea4e1bf9f78e15d4e37';

$fbFile = file_get_contents('https://graph.facebook.com/smashtracker?fields=posts.limit(5)&access_token='.$accessToken);
$fb = json_decode($fbFile);

?>
