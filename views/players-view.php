<?php
	$_PATH =  $_SERVER['DOCUMENT_ROOT'];
?>

<script src='/resources/flot/jquery.flot.js'></script>
<script src='/resources/flot/jquery.flot.js'></script>

<script>
	//put array into javascript variable
  var dataPM = <?php echo json_encode($dataPM); ?>;
	var dataMelee = <?php echo json_encode($dataMelee); ?>;
	var dataSm4 = <?php echo json_encode($dataSm4); ?>;
	var dataRivals = <?php echo json_encode($dataRivals); ?>;
	var datasets = {
		"pm":{label:"Project M", data: dataPM, color: "purple" },
		"sm4sh":{label:"Smash Wii U", data: dataSm4, color: "#FFA567" },
		"melee":{label:"Melee", data: dataMelee, color: "#E20000" },
		"rivals":{label:"Rivals", data: dataRivals, color: "#006400" }
	}
  //plot
  $(function () {


		// insert checkboxes
		var choiceContainer = $("#choices");
		$.each(datasets, function(key, val) {
			choiceContainer.append("<br/><input type='checkbox' name='" + key +
				"' checked='checked' id='id" + key + "'></input>" +
				"<label for='id" + key + "'>"
				+ val.label + "</label>");
		});

		choiceContainer.find("input").click(plotAccordingToChoices);

		function plotAccordingToChoices() {

			var data = [];

			choiceContainer.find("input:checked").each(function () {
				var key = $(this).attr("name");
				if (key && datasets[key]) {
					data.push(datasets[key]);
				}
			});

			if (data.length > 0) {
				$.plot("#placeholder", data, {
					yaxis: {
					        tickFormatter: function(val, axis) { return val < axis.max ? val.toFixed(0) : "<strong>Score</strong>";}
					},
					xaxis: {
						tickDecimals: 0,
						tickFormatter: function(val, axis) { return val < axis.max ? val.toFixed(0) : "<strong>Games</strong>";}
					},

				      legend: {
				        position: "se"
				      }
				});
			}
		}

		plotAccordingToChoices();
	});
</script>

</head>

<body>

<?php require_once($_PATH.'/includes/pageheader.inc.php'); ?>

	<div class='content'>
		<h2 class='page-heading players-bg'><?php echo $username; ?></h2>

		<div class='container-fluid'>

			<div class='row'>

				<div class='col-xs-12 col-sm-6'>

					<h4>About <?php echo $username." ".$form; ?></h4>

					<div class='chars'>
		<?php
				echo $characters;
		?>
	</div>
					<div class='clear'></div>

					<p class='bio'><?php echo $bio; ?></p>

					<hr />
					<?php
					 	echo $placings;
						if ( $chal_res->num_rows > 0 ){
							echo "<h4>Bracket Victories</h4>";

							while ( $row = $chal_res->fetch_assoc() ){
								echo $row['bracket_name']."<br />";
							}
						}
					?>

				</div>

				<div class='col-xs-12 col-sm-6'>

					<div class='row'>
				<?php
						while ( $row = $rec_res->fetch_assoc() ){
							$wins = $row['w'];
							$loss = $row['l'];
							echo "<div class='col-md-4'><span class='h4'>".$row['game_name']."</span><br />";
							echo "<small>Wins: ".$wins." Losses: ".$loss."</small></div>";
						}
				?>
					</div>
					<br />
					<div id='chart-container'>
						<div id="placeholder" style='width:95%; height:300px;'></div>
						<span id="choices" style="width:25%px; display:none;"></span>
					</div>

					<h4>Head to Head</h4>
					<div class='row'>
						<?=$h2h;?>
					</div>

					<hr />
					<h4>Highlights</h4>
					<div class='sets'>
		<?php
			while ($row = $set_res->fetch_assoc()){

				echo "<div class='embed-responsive embed-responsive-16by9'><iframe class='embed-responsive-item' src='https://www.youtube.com/embed/".$row['set_key']."' allowfullscreen></iframe></div>";

			}
		?>
					</div>
				</div>

			</div>




		</div>
	</div>
