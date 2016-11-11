<div class='header-footer' id='header'>
		<div id='logo'>
			<a href='/'><img src='/resources/images/logo.png' alt='SmashTracker' /></a>
		</div>

<?php require_once($_PATH.'/includes/nav.inc.php'); ?>

		<div id='user-control'>
		</div>
	</div>
	<div class='header-bar div-bar'></div>
	<div class='header-spacer'></div>
<?php
	if ( isset($_SESSION['error']) && $_SESSION['error'] !== '' ){
?>
	<div class='alert alert-danger' style='margin:0 10% 30px;' role='alert'>
		<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'> </span>
		<span class='sr-only'>Error:</span>
		  <?php echo $_SESSION['error']; ?>
	</div>


<?php
	} else{}
	if ( isset($_SESSION['success']) && $_SESSION['success'] !== '' ){
?>

	<div class='alert alert-success' style='margin:0 10% 30px;' role='alert'>
		<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'> </span>
		<span class='sr-only'>Error:</span>
			<?php echo $_SESSION['success']; ?>
	</div>
<?php
	} else{}
	$_SESSION['success'] = '';
	$_SESSION['error'] = '';

?>
