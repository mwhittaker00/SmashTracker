<?php $_PATH =  $_SERVER['DOCUMENT_ROOT']; ?>

<script src="/resources/js/_insert-addPlayer.js"></script>

</head>

<body>

<?php require_once($_PATH.'/includes/pageheader.inc.php'); ?>

	<div class='content'>
		<h2 class='page-heading players-bg'>Add a Player</h2>
		<div class='container-fluid'>
			<p>
				Tell us about your new player. Remember to include links to their sets as well as who they play as!
			</p>
			<form class='' action='/process/addplayer/' method='post' id='add-form'>
				<div class='row'>

					<div class='col-md-4'>
						<div class='form-group'>
							<label for='name'>
								Tag Name :
							</label>
							<input type='text' class='form-control' name='name' id='player-name' maxlength=32 required autofocus="true"/>
						</div>

						<div class='form-group'>
							<label for="affiliate">Sponsor/Affiliation: </label>
							<input type='text' class='form-control' name='affiliate' maxlength="24" />
						</div>

						<div class='form-group'>
							<label for='bio'>Bio: </label>
							<textarea name='bio' rows='7' cols='40' maxlenght="2048" class='form-control'></textarea>
						</div>

						<div class='form-group'>
							<label for='placings'>Victories and Placings: </label>
							<textarea name='placings' rows='7' cols='40' maxlenght="1024" class='form-control'></textarea>
						</div>

						<div class='form-group youtube-helper'>
							<label for='sets'>Videos of Notable sets: </label>
							<br />
							<small>Only paste the "key" part of the YouTube URL.</small>
							<img src='/resources/images/youtube-helper.png' alt='Only use the 11 character key from the YouTube URL'/>
							<input type='text' name='set1' />
							<input type='text' name='set2' />
							<input type='text' name='set3' />
							<div class='clear'></div>
						</div>

						<div class='form-group'>
							<input type='submit' value='Add Player' id='add-submit' class='btn btn-default' />
						</div>


					</div>

					<div class='col-md-8'>

						<div class='form-group'>
							<label for='characters' class='characters-label'>
								Select player's characters ( main first ):
							</label>
							<input type='hidden' value='' class='melee-main melee-1' name='meleeCharMain' />
							<input type='hidden' value='' class='melee-2' name='meleeChar2' />
							<input type='hidden' value='' class='melee-3' name='meleeChar3' />

							<input type='hidden' value='' class='pm-main pm-1' name='pmCharMain' />
							<input type='hidden' value='' class='pm-2' name='pmChar2' />
							<input type='hidden' value='' class='pm-3' name='pmChar3' />

							<input type='hidden' value='' class='smash4-main smash4-1' name='smash4CharMain' />
							<input type='hidden' value='' class='smash4-2' name='smash4Char2' />
							<input type='hidden' value='' class='smash4-3' name='smash4Char3' />

							<input type='hidden' value='' class='rivals-main smash4-1' name='rivalsCharMain' />
							<input type='hidden' value='' class='rivals-2' name='rivalsChar2' />
							<input type='hidden' value='' class='rivals-3' name='rivalsChar3' />

							<div class='form-group melee-characters-selected characters-selected'>
								<img class='melee-selected-1 img-thumbnail char-selected' src='' alt='' />
								<img class='melee-selected-2 img-thumbnail char-selected' src='' alt=''/>
								<img class='melee-selected-3 img-thumbnail char-selected' src='' alt=''/>
							</div>

							<div class='form-group pm-characters-selected characters-selected'>
								<img class='pm-selected-1 img-thumbnail char-selected' src='' alt='' />
								<img class='pm-selected-2 img-thumbnail char-selected' src='' alt=''/>
								<img class='pm-selected-3 img-thumbnail char-selected' src='' alt=''/>
							</div>

							<div class='form-group smash4-characters-selected characters-selected'>
								<img class='sm4sh-char smash4-selected-1 img-thumbnail char-selected' src='' alt='' />
								<img class='sm4sh-char smash4-selected-2 img-thumbnail char-selected' src='' alt=''/>
								<img class='sm4sh-char smash4-selected-3 img-thumbnail char-selected' src='' alt=''/>
							</div>

							<div class='form-group rivals-characters-selected characters-selected'>
								<img class='rivals-char rivals-selected-1 img-thumbnail char-selected' src='' alt='' />
								<img class='rivals-char rivals-selected-2 img-thumbnail char-selected' src='' alt=''/>
								<img class='rivals-char rivals-selected-3 img-thumbnail char-selected' src='' alt=''/>
							</div>

							<br />
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

						<!-- SELECTED CHARACTERS -->
						<div class='form-group characters-list'>
					<?php echo $characterList; ?>
						</div>

					</div>
				</div>

				<input type='hidden' name='referer' value='<?php echo $_uri; ?>' />
			</form>

		</div>
	</div>
