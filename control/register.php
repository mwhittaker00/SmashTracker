<?php

if ( isLoggedIn() ){
  header('location:/page/regions/'.$_SESSION['region'].'/');
}

?>
