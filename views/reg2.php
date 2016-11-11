<?php $_PATH =  $_SERVER['DOCUMENT_ROOT']; ?>
<script src='/resources/js/reg2.js'></script>
</head>

<body>

<?php require_once($_PATH.'/includes/pageheader.inc.php'); ?>

	<div class='content'>
		<h2 class='page-heading general-bg'>Almost done...</h2>
		<div class='container-fluid'>
			<div class='row'>
				<div class='col-md-6'>
					<h4>Select your region.</h4>
					<p>
						First, select your region. We'll set this as your primary region, and any players you add will be placed in the same region.
					</p>

					<form action='/process/reg2/' method='post' class='form-inline'>

						<div class='form-group'>
							<label for='region'>Region </label>
							<select name='region' class='form-control' required>
								<option>Select a Region...</option>
					<?php
						// Echo STATE - REGION NAME as select options.
						while ($row = $region_res->fetch_assoc()){
							echo "<option value='".$row['region_id']."'>".$row['region_state']." - ".$row['region_name']."</option>";
						}
					 ?>
							</select>
						</div>

						<input type='hidden' name='referer' value='<?php echo $_uri; ?>' />
						<input type='hidden' class='validation-input' name='validation' value='' />

						<br /><br />
						<div class='well well-sm'>
							<label for='validation'>Human Verification</label>
							<p>Select <strong><?php echo $charKeyName; ?></strong></p>
							<div class='row'>
				<?php
					while ( $row = $char_res->fetch_assoc() ){
				?>
						<div class='col-xs-6 col-sm-3'>
							<img class='char-select img-thumbnail validation-select' src='/resources/images/pm/chars/<?php echo $row['char_fileName']; ?>' attr-id='<?php echo $row['char_id']; ?>' alt='Validation Image' />
						</div>
				<?php
			} // End above WHILE loop
				?>
							</div>
						</div>
						<button type='submit' class='btn btn-default'>Submit</button>
					</form>
				</div>

				<div class='col-md-6'>

					<h4>Your region isn't listed?</h4>
					<p>
						We're still building our regions, so there's a chance we're missing your area. Just fill out the form below and an admin will review your request.
					</p>
					<iframe class='overflow-auto' src="https://docs.google.com/forms/d/1OXc_1kLqot_vm0I7sFh5_i-eyaiu02z9p-p20McWjrA/viewform?embedded=true" width="100%" height="600px" frameborder="0" marginheight="0" marginwidth="0">Loading...</iframe>
				</div>

			</div>
		</div>
	</div>
