<?php
	$_PATH =  $_SERVER['DOCUMENT_ROOT'];
?>


</head>

<body>

<?php require_once($_PATH.'/includes/pageheader.inc.php'); ?>

	<div class='content'>
		<h2 class='page-heading players-bg'>Players</h2>

		<div class='container-fluid'>

			<h4>Featured Players <small>work in progress ;)</small></h4>

			<div id='myCarousel' class='carousel slide' data-ride='carousel'>
				<ol class="carousel-indicators players-carousel-indicators">

			<?php
				// create circle indicators for slider
				for ( $i = 0; $i < $player_cnt; $i++){
					if ( $i == 0 ){
						echo "<li data-target='#myCarousel' data-slide-to='0' class='active'></li>";
					}
					else{
						echo "<li data-target='#myCarousel' data-slide-to='".$i."'></li>";
					}
				}
			?>
				</ol>

				<div class="carousel-inner" role="listbox">

			<?php
				$i = 0;
				while ( $row = $player_res->fetch_assoc() ){
					if ( $i == 0 ){
						$class = " active";
					}
					else{
						$class = "";
					}
					echo "<div class='carousel-caption well well-sm carousel-bio container-fluid item".$class."'>";
					echo "<div class='row'>";
					echo "<div class='col-md-4'>";
					echo "<h4><a href='/page/players/".$row['user_id']."/'>".htmlentities($row['user_name'])."</a></h4>";
					echo "<h5><a href='/page/regions/".$row['region_id']."/'>".htmlentities($row['region_name'])."</a></h5>";
					echo "<div class='embed-responsive embed-responsive-16by9'>";
					if ( strlen($row['set_key']) > 0 ){
						echo "<iframe class='embed-responsive-item' src='https://www.youtube.com/embed/".$row['set_key']."' allowfullscreen></iframe>";
					}
					else{}
					echo "</div>";

					echo "</div>";
					echo "<div class='col-md-8'>";
					echo "<p>".nl2br(htmlentities($row['user_bio']))."</p>";
					echo "</div>";
					echo "</div>";
					echo "</div>";
					$i++;
				}

			?>

				</div>

			</div>

			<h3>SmashTracker: By the numbers</h3>
			<hr />
			<div class='row'>
				<div class='col-md-8'>
					<h4>Matches Submitted</h4>
					<div class='row'>
		<? while ($row=$match_res->fetch_assoc()){ ?>
						<div class='col-sm-2'>
							<h6><?=$row['game_name'];?></h6>
							<?=$row['counter'];?>
						</div>
		<? } // END while ?>
					</div>
				</div>

				<div class='col-md-4'>
					<h4>Most Used Mains</h4>
		<?php foreach ( $charData as $char ){
				$src=$char['fileName'];
				$alt=$char['displayName'];
		?>

				<img src='<?=$src;?>' alt='<?=$alt;?>' class='home-character character' />

		<? } // END foreach ?>

				</div>
			</div>



		</div>
	</div>
