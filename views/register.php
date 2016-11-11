<?php $_PATH =  $_SERVER['DOCUMENT_ROOT']; ?>

<script src="/resources/js/_register.js"></script>

</head>

<body>

<?php require_once($_PATH.'/includes/pageheader.inc.php'); ?>

	<div class='content'>
		<h2 class='page-heading general-bg'>Let's get started.</h2>
		<div class='container-fluid'>
			<div class='row'>
				<div class='col-sm-5'>
					<h4>Create an account.</h4>

					<p>Sign up to start promoting your region.</p>

					<form action='/process/register/' method='post' id='reg-register'>

						<div class='form-group'>
							<label for='username'>User name</label>
							<input type='text' class='form-control' name='username' maxlength=32 required />
						</div>

						<div class='form-group'>
							<label for='password'>Password</label>
							<input type='password' class='form-control' id='password' name='password' maxlength='48' required />
						</div>

						<div class='form-group'>
							<label for='repassword'>Re-Enter Password</label>
							<input class='form-control' type='password' id='repassword' name='repassword' maxlength='48' required /><span class='form-valid' id='pass-valid'></span>
						</div>

						<div class='form-group'>
							<label for='email'>Email Address</label>
							<input type='text' class='form-control' id='email' name='email' maxlength='48' email required />
						</div>

						<div class='form-group'>
							<label for='reemail'>Re-Enter Email</label>
							<input class='form-control' type='text' id = 'remail' name='remail' maxlength='48' email required /><span class='form-valid' id='email-valid'></span>
						</div>
						<div class='form-helper'>*We won't send you emails unless you need help with your password</div>

						<input type='hidden' name='target' value='/page/reg2/' />
						<input type='hidden' name='referer' value='<?php echo $_uri; ?>' />
						<p><small>By clicking "Sign Up" below, you agree
							<br />
							to the <a href='/page/terms/' target='_blank'>Terms of Use</a>.</small></p>

						<button type='submit' class='btn btn-default' name='signup'>Sign Up</button>

					</form>
					<hr />
					<p>
						<strong>Do you need an account?</strong>
					</p>
					<p>
						Short answer? Probably not.
					</p>
					<p>
						You only need to worry about an account if you consider yourself a TO or other sort of organizer in your local Smash scene. You'll need an approved account if you'll be adding players, updating bios, uploading match information, or managing regional media.
					</p>
					<p>
						If this sounds like you, you'll need an account. Sign up now to get started!
					</p>

				</div>
				<div class='col-md-1'></div>
				<div class="col-sm-5">
					<h4>Welcome back.</h4>

					<p>Log in to your SmashTracker account to get back to business.</p>

					<form id='reg-signin' action='/process/login/' method='post'>
						<div class='form-group'>
						  <label for='username'>User name </label>
						  <input type='text' class='form-control' placeholder = 'User name' maxlength=24 name='username' required />
						</div>

						<div class='form-group'>
						  <label for='password'>Password</label>
						  <input type='password' class='form-control' placeholder='Password' maxlength=24 name='password' required />
						</div>

						<input type='hidden' name='target' value='/page/reg2/' />
						<input type='hidden' name='referer' value='<?php echo $_uri; ?>' />

						<button type='submit' class='btn btn-default' name='login'>Log In</button>

					</form>

				</div>

			</div>

		</div>
	</div>
