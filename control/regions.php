<?php
$_PATH = $_SERVER['DOCUMENT_ROOT'];

$reg_qry = "SELECT DISTINCT regions.region_id, region_name, region_state
							FROM regions
							JOIN user_region
								ON user_region.region_id  = regions.region_id
							ORDER BY region_state ASC";
$reg_res = $db->query($reg_qry);


?>
