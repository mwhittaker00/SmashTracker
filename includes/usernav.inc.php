<?php
if ( isLoggedIn() ){
	$link = "<li class='user-nav'><a href='/players/addmatch/'>Add Matches</a></li>";
	$link = $link."<li class='user-nav'><a href='/players/addplayer/'>Add a Player</a></li>";

	if ( $_SESSION['region'] != 0 ){
		$link = $link."<li class='user-nav'><a href='/page/regions/".$_SESSION['region']."/'>My Region</a></li>";
	} else{}

	$link = $link."<li class='user-nav'><a href='/process/logout/'>Log Out</a></li>";
}
else{
	$link = "<li class='user-nav'><a href='/page/register/'>Sign Up | Log In</a></li>";
}

echo $link;
?>
