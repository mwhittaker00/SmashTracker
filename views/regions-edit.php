<?php $_PATH =  $_SERVER['DOCUMENT_ROOT'];  ?>

</head>

<body>

<?php require_once($_PATH.'/includes/pageheader.inc.php'); ?>

	<div class='content'>
		<h2 class='page-heading regions-bg'><?php echo $region; ?></h2>
		<div class='container-fluid'>
			<div class='row'>
				<div class='col-md-6'>
					<h4>Regional Mods</h4>

          <p>Who can make changes to this page and players in your region, as well as updating match information.</p>

					<ul class='player-list'>

				<?php
					while ( $row = $to_res->fetch_assoc() ){
						echo "<li><a href='/page/players/".$row['user_id']."/'>".$row['user_name']."</a></li>";
					}
				?>

					</ul>

          <h4><?php echo $region; ?> Players</h4>
            <ul class='player-list'>
        <?php
          while ( $row = $player_res->fetch_assoc() ){
						echo "<li><a href='/page/players/".$row['user_id']."/' target='_blank'>".$row['user_name']."</a></li>";
					}
        ?>
            </ul>
				</div>

				<div class='col-md-6'>
          <h4>Edit <?php echo $region; ?>'s Bio</h4>
					<form action='/process/regionbio/' method='post'>
            <textarea maxlength=2400 class='edit-bio' name='bio'><?php echo $regionBio; ?></textarea>
            <input type='hidden' name='referer' value='<?php echo $_uri; ?>' />
            <button type='submit' class='btn btn-default'>Submit</button>
          </form>

          <h4>Sets and Rankings</h4>

          <p>Sets and rankings are dynamically generated from the content you provide to SmashTracker. At this time, the displayed sets are pulled from the YouTube videos you have assigned to your players.</p>

				</div>

				</div>
			</div>
	</div>
