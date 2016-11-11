<?php
  $region = $_SESSION['region'];
  if ( !isMod() ){
    simFail();
  }
  echo "here";
  $bio = mysqli_real_escape_string($db, $_POST['bio']);
  $referer = mysqli_real_escape_string($db, $_POST['referer']);
  $target = '/page/regions/'.$region.'/';

  $bio_qry = "UPDATE regions
                SET region_bio = '$bio'
                WHERE region_id = $region
                LIMIT 1";
  $bio_res = $db->query($bio_qry);

  if ( $bio_res ){
    $_SESSION['success'] = "Region bio successfully updated.";
    $success = 'true';
  }
  else{
    $_SESSION['error'] = "Something went wrong. Please try again.";
    $success = 'false';
  }

?>
