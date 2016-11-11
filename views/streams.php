<?php $_PATH =  $_SERVER['DOCUMENT_ROOT'];?>
<script src="/resources/js/_streams.js"></script>
</head>

<body>

<?php require_once($_PATH.'/includes/pageheader.inc.php');?>

	<div class='content'>
		<h2 class='page-heading streams-bg'>Super Smash Bros. Streams</h2>

		<div class='container-fluid'>

			<div id='streams' class='row-fluid'>
				<div id='now-playing' class='col-md-8'>
					<h4>Now Streaming</h4>

					<div class='well well-sm'>
						<span class='glyphicon glyphicon-facetime-video'></span>
						<a target='_blank' href='http://www.twitch.tv/<?=$channelName;?>'>
					<?=$displayName;?>
						</a>

						<span class='view-info'><span class='glyphicon glyphicon-eye-open'></span>
					<?=$viewers;?>

						<span class='glyphicon glyphicon-user'></span><?=$followers;?></span>
						<br /><span class='game-info'><?=$gameName;?></span>
					</div>

					<div id='player'>
						<iframe src='http://www.twitch.tv/<?=$channelName;?>/embed' frameborder='0' scrolling='no' ></iframe>
					</div>

				</div>

				<div id='stream-chat' class='col-md-4'>
					<h4><?=$displayName;?>'s Chat</h4>

					<iframe src='http://www.twitch.tv/<?=$channelName;?>/chat?popout=' frameborder='0' scrolling='no' height=''></iframe>
				</div>

			</div>

			<div class='clear'></div>

			<div id='live-streams' class='row-fluid'>
				<h3 class='page-heading streams-bg'>Live Streams</h3>
				<h4 class='page-heading about-bg'>
					<a role='button' class='stream-toggle' data-toggle='collapse' data-parent='#accordion' href='#collapseSmash4' aria-expanded='false' aria-controls='collapseSmash4'>
						Smash 4 <span class='glyphicon glyphicon-chevron-down' aria-hidden='true'></span>
					</a>
				</h4>

				<div id='collapseSmash4' class='collapse'>
			<?php foreach ( $info['wiiU'] as $stream ){ ?>

				<div class='col-md-3 col-sm-6'>
					<div class='well well-sm'>
						<span class='glyphicon glyphicon-facetime-video'></span>
						<a target='_blank' href='http://www.twitch.tv/<?=$stream['channelName'];?>'>
					<?=$stream['displayName'];?>
						</a>

						<span class='view-info'><span class='glyphicon glyphicon-eye-open'></span>
					<?=$stream['viewers'];?>

						<span class='glyphicon glyphicon-user'></span><?=$stream['followers'];?></span>
						<br /><br />
						<a target='_blank' href='http://www.twitch.tv/<?=$stream['channelName'];?>'>
							<img src='<?=$stream['preview'];?>' alt='Twitch Stream Preview' />
						</a>
					</div>
				</div>

			<?php } // ends FOREACH ?>
				</div>
				<div class='clear'></div>


				<h4 class='page-heading home-bg'>
					<a role='button' class='stream-toggle' data-toggle='collapse' data-parent='#accordion' href='#collapseMelee' aria-expanded='false' aria-controls='collapseMelee'>
						Melee <span class='glyphicon glyphicon-chevron-down' aria-hidden='true'></span
					</a>
				</h4>

				<div id='collapseMelee' class='collapse'>
			<?php foreach ( $info['melee'] as $stream ){ ?>

				<div class='col-md-3 col-sm-6'>
					<div class='well well-sm'>
						<span class='glyphicon glyphicon-facetime-video'></span>
						<a target='_blank' href='http://www.twitch.tv/<?=$stream['channelName'];?>'>
					<?=$stream['displayName'];?>
						</a>

						<span class='view-info'><span class='glyphicon glyphicon-eye-open'></span>
					<?=$stream['viewers'];?>

						<span class='glyphicon glyphicon-user'></span><?=$stream['followers'];?></span>
						<br /><br />
						<a target='_blank' href='http://www.twitch.tv/<?=$stream['channelName'];?>'>
							<img src='<?=$stream['preview'];?>' alt='Twitch Stream Preview' />
						</a>
					</div>
				</div>

			<?php } // ends FOREACH ?>
				</div>
				<div class='clear'></div>

				<h4 class='page-heading players-bg'>
					<a role='button' class='stream-toggle' data-toggle='collapse' data-parent='#accordion' href='#collapsePM' aria-expanded='false' aria-controls='collapsePM'>
						Project M <span class='glyphicon glyphicon-chevron-down' aria-hidden='true'></span>
					</a>
				</h4>

				<div id='collapsePM' class='collapse'>
			<?php foreach ( $info['pm1'] as $stream ){ ?>

				<div class='col-md-3 col-sm-6'>
					<div class='well well-sm'>
						<span class='glyphicon glyphicon-facetime-video'></span>
						<a target='_blank' href='http://www.twitch.tv/<?=$stream['channelName'];?>'>
					<?=$stream['displayName'];?>
						</a>

						<span class='view-info'><span class='glyphicon glyphicon-eye-open'></span>
					<?=$stream['viewers'];?>

						<span class='glyphicon glyphicon-user'></span><?=$stream['followers'];?></span>
						<br /><br />
						<a target='_blank' href='http://www.twitch.tv/<?=$stream['channelName'];?>'>
							<img src='<?=$stream['preview'];?>' alt='Twitch Stream Preview' />
						</a>
					</div>
				</div>
			<?php } // ends FOREACH ?>

			<?php foreach ( $info['pm2'] as $stream ){ ?>

				<div class='col-md-3 col-sm-6'>
					<div class='well well-sm'>
						<span class='glyphicon glyphicon-facetime-video'></span>
						<a target='_blank' href='http://www.twitch.tv/<?=$stream['channelName'];?>'>
					<?=$stream['displayName'];?>
						</a>

						<span class='view-info'><span class='glyphicon glyphicon-eye-open'></span>
					<?=$stream['viewers'];?>

						<span class='glyphicon glyphicon-user'></span><?=$stream['followers'];?></span>
						<br /><br />
						<a target='_blank' href='http://www.twitch.tv/<?=$stream['channelName'];?>'>
							<img src='<?=$stream['preview'];?>' alt='Twitch Stream Preview' />
						</a>
					</div>
				</div>

			<?php } // ends FOREACH ?>
				</div>

				<div class='clear'></div>

				<h4 class='page-heading regions-bg'>
					<a role='button' class='stream-toggle' data-toggle='collapse' data-parent='#accordion' href='#collapseBrawl' aria-expanded='false' aria-controls='collapseBrawl'>
						Brawl <small><em>sometimes PM</em></small> <span class='glyphicon glyphicon-chevron-down' aria-hidden='true'></span>
					</a>
				</h4>

				<div id='collapseBrawl' class='collapse'>
			<?php foreach ( $info['brawl'] as $stream ){ ?>

				<div class='col-md-3 col-sm-6'>
					<div class='well well-sm'>
						<span class='glyphicon glyphicon-facetime-video'></span>
						<a target='_blank' href='http://www.twitch.tv/<?=$stream['channelName'];?>'>
					<?=$stream['displayName'];?>
						</a>

						<span class='view-info'><span class='glyphicon glyphicon-eye-open'></span>
					<?=$stream['viewers'];?>

						<span class='glyphicon glyphicon-user'></span><?=$stream['followers'];?></span>
						<br /><br />
						<a target='_blank' href='http://www.twitch.tv/<?=$stream['channelName'];?>'>
							<img src='<?=$stream['preview'];?>' alt='Twitch Stream Preview' />
						</a>
					</div>
				</div>

			<?php } // ends FOREACH ?>
				</div>

				<div class='clear'></div>

				<h4 class='page-heading streams-bg'>
					<a role='button' class='stream-toggle' data-toggle='collapse' data-parent='#accordion' href='#collapse64' aria-expanded='false' aria-controls='collapse64'>
						Super Smash Bros. 64 <span class='glyphicon glyphicon-chevron-down' aria-hidden='true'></span>
					</a>
				</h4>

				<div id='collapse64' class='collapse'>
			<?php foreach ( $info['ssb'] as $stream ){ ?>

				<div class='col-md-3 col-sm-6'>
					<div class='well well-sm'>
						<span class='glyphicon glyphicon-facetime-video'></span>
						<a target='_blank' href='http://www.twitch.tv/<?=$stream['channelName'];?>'>
					<?=$stream['displayName'];?>
						</a>

						<span class='view-info'><span class='glyphicon glyphicon-eye-open'></span>
					<?=$stream['viewers'];?>

						<span class='glyphicon glyphicon-user'></span><?=$stream['followers'];?></span>
						<br /><br />
						<a target='_blank' href='http://www.twitch.tv/<?=$stream['channelName'];?>'>
							<img src='<?=$stream['preview'];?>' alt='Twitch Stream Preview' />
						</a>
					</div>
				</div>

			<?php	} // ends FOREACH ?>
				</div>

		</div><!-- END LIVE-STREAMS DIV -->


		</div>
	</div>
