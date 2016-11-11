<?php $_PATH =  $_SERVER['DOCUMENT_ROOT'];  ?>

	</script>
</head>

<body>

<?php require_once($_PATH.'/includes/pageheader.inc.php'); ?>

	<div class='content'>
		<h2 class='page-heading regions-bg'>Find a Region</h2>
		<div class='container-fluid'>
			<div class='row region-list'>

		<?php
			$states = array();
			while ( $row = $reg_res->fetch_assoc()){
					if ( !in_array($row['region_state'],$states) ){
						array_push($states,$row['region_state']);
						echo "<h4>".$row['region_state']."</h4>";
					}
					echo "<a href='/page/regions/".$row['region_id']."/'>".$row['region_name']."</a><br />";
			}

		?>

			</div>
		</div>
	</div>
