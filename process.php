<?php
$_PATH =  $_SERVER['DOCUMENT_ROOT'];

require_once($_PATH.'/functions/init.func.php');

if ( isset($_GET['method']) ){
		if ( $_GET['method'] == 'logout' ){
			logout();
		}
		if ( isset($_POST['referer']) ){
			$script = $_GET['method'];
			$referer = $_POST['referer'];
			processForm($_PATH,$script,$referer,$db);
		}
}


else{
	simFail();
}

?>
