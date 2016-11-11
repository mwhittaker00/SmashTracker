<?php
	$_PATH =  $_SERVER['DOCUMENT_ROOT'];
?>
<script src="/resources/js/_edit-player.js"></script>

</head>

<body>

<?php require_once($_PATH.'/includes/pageheader.inc.php'); ?>

	<div class='content'>
		<h2 class='page-heading players-bg'>Edit <?php echo $username; ?>'s Profile</h2>

		<div class='container-fluid'>
			<p>
				Update your player's profile. Make sure to include hype new videos or tourney placings!
			</p>
			<form class='' action='/process/editplayer/' method='post' id='add-form'>
				<div class='row'>

					<div class='col-md-4'>
						<div class='form-group'>
							<label for='name'>
								Tag Name:
							</label>
							<input type='text' class='form-control' value='<?php echo $username; ?>' name='name' id='player-name' maxlength=32 required />
						</div>

						<div class='form-group'>
							<label for="affiliate">Sponsor/Affiliation: </label>
							<input type='text' class='form-control' value='<?php echo $aff; ?>' name='affiliate' maxlength="24" />
						</div>

						<div class='form-group'>
							<label for='bio'>Bio: </label>
							<textarea name='bio' rows='7' cols='40' maxlenght="2048" class='form-control'><?php echo $bio; ?></textarea>
						</div>

						<div class='form-group'>
							<label for='placings'>Victories and Placings: </label>
							<textarea name='placings' rows='7' cols='40' maxlenght="1024" class='form-control'><?php echo $placings; ?></textarea>
						</div>

						<div class='form-group youtube-helper'>
							<label for='sets'>Videos of Notable sets: </label>
							<br />
							<small>Only paste the "key" part of the YouTube URL.</small>
							<img src='/resources//images/youtube-helper.png' alt='Only use the 11 character key from the YouTube URL'/>
							<input type='text' name='set1' value='<?php echo (isset($sKey[0]) ?$sKey[0] : ''); ?>'/>
							<input type='text' name='set2' value='<?php echo (isset($sKey[1]) ?$sKey[1] : ''); ?>'/>
							<input type='text' name='set3' value='<?php echo (isset($sKey[2]) ?$sKey[2] : ''); ?>'/>
							<div class='clear'></div>
						</div>

						<div class='form-group'>
							<input type='hidden' value='<?php echo $playerID; ?>' name='playerID' required />
							<input type='submit' value='Save Changes' id='add-submit' class='btn btn-default' />
						</div>


					</div>

					<div class='col-md-8'>

						<div class='form-group'>
							<label for='characters' class='characters-label'>
								<span class='btn reset-btn'>Reset Characters</span><span class='select-main'>Select player's main:</span>
							</label>
							<div id='chars-reset'>
							</div>

							<div class='select-main'>
								<div class='btn btn-default char-select-toggle melee-toggle' attr-game='melee'>
									Melee
								</div>
								<div class='btn btn-default char-select-toggle pm-toggle' attr-game='pm'>
									Project M
								</div>
								<div class='btn btn-default char-select-toggle smash4-toggle' attr-game='smash4'>
									Smash 4
								</div>
								<div class='btn btn-default char-select-toggle rivals-toggle' attr-game='rivals'>
									Rivals of Aether
								</div>
							</div>
						</div>

						<!-- SELECTED CHARACTERS -->
						<div class='form-group'>
				<?php
					echo $selectedChars;
				?>
					</div>

						<div class='form-group characters-list edit-characters-list'>

							<?php
								echo $characterList;
							?>

						</div>

					</div>
				</div>
				<input type='hidden' name='referer' value='/page/players/<?php echo $playerID; ?>/' />
			</form>


		</div>
	</div>
