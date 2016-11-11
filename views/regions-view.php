<?php $_PATH =  $_SERVER['DOCUMENT_ROOT'];  ?>

<link href="/resources/styles/footable.core.min.css" rel="stylesheet" type="text/css" />
<link href="/resources/styles/footable.standalone.min.css" rel="stylesheet" type="text/css" />

	<script src="/resources/js/footable.min.js" type="text/javascript"></script>
	<script src="/resources/js/footable.sort.js" type="text/javascript"></script>
	<script src="/resources/js/footable.striping.js" type="text/javascript"></script>
	<script src="/resources/js/footable.filter.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(function () {
			$('.footable').footable();
		});
	</script>
</head>

<body>

<?php require_once($_PATH.'/includes/pageheader.inc.php');?>

	<div class='content'>
		<h2 class='page-heading regions-bg'><?=$region;?></h2>
		<div class='container-fluid'>
			<div class='row'>
				<div class='col-md-6'>
					<h4>Regional Mods <?=$form;?></h4>

					<ul class='player-list'>

				<?php while ( $row = $to_res->fetch_assoc() ){ ?>
						<li><a href='/page/players/<?=$row['user_id'];?>/'><?=htmlentities($row['user_name']);?></a></li>
				<?	} ?>

					</ul>
					<hr />
					<h4>About <?=$region;?></h4>
					<?=$regionBio;?>

					<hr />
					<h4>
						<a role='button' data-toggle='collapse' data-parent='#accordion' href='#collapsePlayers' aria-expanded='false' aria-controls='collapsePlayers'>
							<?php echo $region; ?> Players <span class='glyphicon glyphicon-chevron-down' aria-hidden='true'></span>
						</a>
					</h4>

					  <ul id='collapsePlayers' class='collapse player-list'>
        <?php
          while ( $row = $player_res->fetch_assoc() ){
						echo "<li><a href='/page/players/".$row['user_id']."/' target='_blank'>".$row['user_name']."</a></li>";
					}
        ?>
            </ul>
						<hr />
					<h4>Player Sets</h4>

				<?php while ( $row = $set_res->fetch_assoc() ){ ?>
							<div class='region-set'>
							<a class='region-set-player' href='/page/players/<?=$row['user_id'];?>/'><?=htmlentities($row['user_name']);?></a><br />
							<div class='embed-responsive embed-responsive-16by9'><iframe class='embed-responsive-item' src='https://www.youtube.com/embed/<?=htmlentities($row['set_key']);?>' allowfullscreen></iframe></div>
							</div>
				<? } ?>
				</div>

				<div class='col-md-6'>
						<h4>SmashTracker Rankings</h4>
						<p>
							<label for='footable-search'>
								Filter by Game:
							</label>
							<input type='text' name='footable-search' id='foot-filter' />

						</p>
						<table class='footable table' data-filter="#foot-filter">
							<thead>
								<tr>
									<th class='footable-first-column'>Player</th>
									<th>Game</th>
									<th class='footable-last-column'>Score</th>
								</tr>
							</thead>
					<?php
				  while($row = $user_res->fetch_assoc()){
							$username = htmlentities($row['user_name']);
							$rowID = htmlentities($row['user_id']);
							$game = htmlentities($row['game_name']);
							$score = htmlentities($row['score']);
					?>
							<tr>
								<td>
									<a href='/page/players/<?=$rowID;?>/'><?=$username;?></a>
								</td>
								<td>
									<?=$game;?>
								</td>
								<td>
									<?=$score;?>
								</td>
							</tr>
					<? } ?>
						</table>
					</div>

				</div>
			</div>
	</div>
