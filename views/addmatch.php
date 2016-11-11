<?php
	$_PATH =  $_SERVER['DOCUMENT_ROOT'];
?>
<script src="/resources/js/_add-match.js"></script>
</head>

<body>

<?php require_once($_PATH.'/includes/pageheader.inc.php'); ?>

	<div class='content'>
		<h2 class='page-heading players-bg'>Add Matches</h2>

		<div class='container-fluid'>

			<div class='row'>

				<div class='col-md-5'>
					<h4>Upload a Challonge bracket.</h4>
					<p>It's easy to upload your bracket straight from Challonge! We'll calculate all of the match data and designate a tourney winner.</p>
					<p>Just a few things to keep in mind before you start:</p>
					<ul>
						<li><strong>Make sure participant names in your bracket match their SmashTracker profile.</strong></li>
						<li>Add any new players before you upload a bracket.</li>
						<li>Names that do not match will be ignored.</li>
						<li>If we cannot find a player, the set will not be entered for either of the players.</li>
						<li>We will remove any spaces on either side of a players name.</li>
						<li>Names <strong>are not</strong> case-sensitive.</li>
					</ul>

					<form id='challonge-upload' action='/process/addtourney/' method='post'>

						<div class='form-group challonge-helper'>
							<label for='bracketurl'>Challonge URL</label><br />
							<input type='text' placeholder='Only pass the end of your Challonge URL' name='bracketurl' maxlength='128' class='form-control' required />
							<img src='/resources/images/challonge-url.jpg' alt="Simply enter the end of your bracket's URL" />
						</div>

						<div class='form-group challonge-helper'>
							<label for='bracketsub'>Challonge Subdomain <sup>*if applicable</sup></label><br />
							<input type='text' placeholder='Only needed if your account uses a subdomain.' name='bracketsub' maxlength='128' class='form-control' />
							<img src='/resources/images/challonge-sub.jpg' alt="Provide your Challonge subdomain." />
						</div>

						<div class='form-group'>
							<label for='game'>
								Game:
						  </label>
							<select name='game' id='game' class='form-control'required>
						    <option value='' default>Select a game</option>
								<?=$gamesList;?>
							</select>
						</div>


						<input type='hidden' name='referer' value='<?php echo $_uri; ?>' />
						<input type='submit' value='Upload Bracket' class='btn btn-default' />
					</form>



			</div>
			<div class='col-md-1'></div>

			<div class='col-md-6'>
				<h4>Add individual matches.</h4>
				<p>Select the players, the game, then click "Next".</p>

				<p>Pick the winner <em>of the set</em> and submit the form to update each player's rank.</p>
				<p>If you are uploading matches using bracket data, use the following order to get the most accurate scoring:</p>
				<ul>
					<li>Enter matches from <strong>winner's bracket</strong> first, but <strong>do not</strong> include Grand Finals.</li>
					<li>Enter <strong>all</strong> matches in the <strong>loser's bracket</strong>.</li>
					<li>Enter the <strong>Grand Finals</strong> matches, including any bracket reset.</li>
				</ul>

				<form action='' method='post' id='rank-form'>

					<div class='form-group'>
						<label for='player1'>
							Player 1:
						</label>
						<select name='player1' id='player1' class='form-control' required>
					    <option value='' default>Select a player</option>
			  <?php
			  while($row = $user_res->fetch_assoc()){
						$userID = htmlentities($row['user_id']);
						$userName = htmlentities($row['user_name']);
						echo "<option value='".$userID."'>".$userName."</option>";
					}
			  ?>
						</select>
					</div>

					<div class='form-group'>
						<label for='player2'>
							Player 2:
						</label>
						<select name='player2' id='player2' class='form-control' required>
					    <option value='' default>Select a player</option>
		  <?php
		  mysqli_data_seek($user_res,0);
		  while($row = $user_res->fetch_assoc()){
						echo "<option value='".$row['user_id']."'>".$row['user_name']."</option>";
					}
		  ?>
						</select>
					</div>

					<div class='form-group'>


					<div class='form-group'>
						<label for='game'>
							Game:
					  </label>
						<select name='game' id='game' class='form-control'required>
					    <option value='' default>Select a game</option>
							<?=$gamesList;?>
						</select>
					</div>

					<input type='button' class='btn btn-default' value='Next' id='nextStep' />

					<div id='select-winner'>

						<div class='form-group'>
							<label for='winner'>
								Winner:
							</label>
							<select name='winner' id='winner' class='form-control'>
								<option id='winner1'></option>
								<option id='winner2'></option>
							</select>
						</div>
						<input type='hidden' name='referer' value='<?php echo $_uri; ?>' />

						<input type='submit' class='btn btn-default' value='Submit' id='rank-submit' />

					</div>
				</div>
				</form>
				<div class='outcome'></div>
			</div>

		</div>
	</div>
</div>
