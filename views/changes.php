<?php
	$_PATH =  $_SERVER['DOCUMENT_ROOT'];
?>


</head>

<body>

<?php require_once($_PATH.'/includes/pageheader.inc.php'); ?>

	<div class='content'>
		<h2 class='page-heading general-bg'>Change Log</h2>

		<div class='container-fluid'>

      <div class='col-md-6'>
			  <h4>Changes</h4>
				<dl>
					<dt>August 21, 2015</dt>
					<dd>Added "Games" drop-down list to Challonge upload section.</dd>
				</dl>
				
        <dl>
          <dt>August 19, 2015</dt>
          <dd>Created change log page.</dd>
          <dd>Fixed an issue that allowed TOs to submit brackets for another region, which could block another region from uploading their own brackets.</dd>
					<dd>Up and down arrows to show state of collapsed areas on Streams page. </dd>

        </dl>
      </div>

      <div class='col-md-6'>
        <h4>Known Issues</h4>

				<ul>
					<li>If a game is not set on the actual Challonge bracket, it will fail to upload using the Challonge upload form.</li>
        	<li>Challonge - SmashTracker name matching is too strict. Consider use of aliases as well as user feedback if non-matching names are found before allowing submission.</li>
        	<li>I do way too many get up attacks.</li>
        	<li>On Streams Page, need to replace "down arrow" with "up arrow" when a category is expanded.</li>
				</ul>
				<hr />

				<h4>Planned Features</h4>

				<dl>
					<dt>Featured Players</dt>
					<dd>Allow TOs to designate a few Featured Players. These players will be added to a pool that may be displayed on the random slide on the "Players" default page.</dd>

				</dl>
      </div>


		</div>
	</div>
