<?php $_PATH =  $_SERVER['DOCUMENT_ROOT']; ?>

	<link rel="stylesheet" type="text/css" href="/resources/styles/slider.css" />

</head>

<body>
<?php require_once($_PATH.'/includes/pageheader.inc.php'); ?>

	<div class='content'>
		<h2 class='page-heading home-bg'>Welcome to SmashTracker</h2>

		<div class='container-fluid'>

			<div class='row'>
				<div class='col-sm-7 col-md-8'>
					<div id='myCarousel' class='carousel slide' data-ride='carousel'>
						<ol class="carousel-indicators">
					    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
					    <li data-target="#myCarousel" data-slide-to="1"></li>
					    <li data-target="#myCarousel" data-slide-to="2"></li>
					  </ol>

						<div class="carousel-inner" role="listbox">
					    <div class="item active">
					      <img src="/resources/images/slider/stream-slide.jpg" alt="Welcome to SmashTracker.">
								<div class='carousel-caption'>Find Twitch streams for every game.</div>
					    </div>

					    <div class="item">
					      <img src="/resources/images/slider/slide2.jpg" alt="Rank local players with built-in Challonge support.">
								<div class='carousel-caption'>Rank local players with built-in Challonge support.</div>
					    </div>

					    <div class="item">
					      <img src="/resources/images/slider/slide3.jpg" alt="Manage profiles for top players so commentators have something to talk about.">
								<div class='carousel-caption'>Player profiles for bios, videos, and stat tracking.</div>
					    </div>

					  </div>

					  <!-- Left and right controls -->
					  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
					    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					    <span class="sr-only">Previous</span>
					  </a>
					  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
					    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					    <span class="sr-only">Next</span>
					  </a>
					</div>

					<h4>We're about to do something awesome.</h4>

					<p>It's time to keep track of your Smashing. SmashTracker will be a way to help the Smash Brothers community track matches between players, tourney victories, and ranking metrics.</p>

					<p>Our main goal is to provide a service to the scenes that build this community. Whether you're from MDVA or a small community college club, we want to help you promote your scene. Brag about your region or scene, link to YouTube videos and streams, or simply use the ranking system to help complement your scene's Power Rankings.</p>

					<p>You can see a more complete list of our goals and planned features on the <a href='/page/about/'>About</a> page.</p>

					<hr />
					<div class='home-facebook'>
						<h4 class='float-right'>
								<a href='https://www.facebook.com/smashtracker' target='_blank'>Read more >></a>
						</h4>
						<h4>News and Updates</h4>


				<?php
				$message = '';
				foreach ( $fb->posts->data as $post ){
					$message = $post->message;
					$created_time = $post->created_time;
					$id = explode('_',$post->id);
					$id = $id[1];
					$t = strtotime($created_time);
					$created_time = date('F d, Y', $t);

					if ( strlen($message) > 0 ){
				?>
						<div class='well well-sm'>
							<h5>
								<a href='https://www.facebook.com/smashtracker/posts/<?php echo $id; ?>/' target='_blank'>
									<?php echo $created_time; ?> <img src='/resources/images/facebook-external.png' class='facebook-external' alt='Link to post on Facebook' />
								</a>
							</h5>
							<?php echo nl2br($message); ?>
						</div>

				<?php	} else{}
				} // end FOREACH

				?>


					</div>

				</div>

				<div class='col-sm-5 col-md-4'>
					<h4>Recently Updated</h4>

<?php
	while($row = $players_res->fetch_assoc()){
		if ( $row['game_id'] == 2 ){
			$game='melee';
		}
		else if ( $row['game_id'] == 3 ){
			$game = 'pm';
		}
		else if ( $row['game_id'] == 5 ){
			$game = 'smash4';
		}
		else if ( $row['game_id'] == 0 ){
			$game = 'rivals';
		}
		echo "<div class='home-updates well media'>";
		echo "<div class='media-body'>";
		echo "<div class='media-heading'><span class='h5'><a href='/page/regions/".$row['region_id']."/'>".$row['region_name']."</a></span></div>";
		echo $row['bracket_name']."<br />";
		echo "<a href='/page/players/".$row['user_id']."/'>".$row['user_name']."</div>";
		echo "<div class='media-left'><img src='/resources/images/".$game."/chars/".$row['char_fileName']."' alt='".$row['char_displayName']."'class='home-character character media-object' /></a></div>";
		echo "</div>";
		}
?>

				<hr />
				<a class="twitter-timeline" href="https://twitter.com/SSBTracker" data-widget-id="595636625679491072">Tweets by @SSBTracker</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

				</div>

			</div>

		</div>
	</div>
