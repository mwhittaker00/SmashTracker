<?php

if ( isLoggedIn() ){
  header('location:/page/regions/'.$_SESSION['region'].'/');
}

$key = $var;
$_SESSION['reg_key'] = $key;

$key_qry = "SELECT reg_key_val, reg_key_activated FROM reg_key
              WHERE reg_key_val = '$key'
              LIMIT 1";
$key_res = $db->query($key_qry);
$key_cnt = $key_res->num_rows;
$key_row = $key_res->fetch_assoc();

if ( $key_cnt == 0 ){
  $_SESSION['error'] = "Invalid registration code.";
  simFail();
}

if ( $key_row['reg_key_activated'] == 1 ){
  $_SESSION['error'] = 'This registration code has already been used.';
  simFail();
}



?>
