<?php

// Include necessary files

require_once( 'sources/bootstrap.php' );

extract($_GET);

ob_start();

if( isset($i) ){

	$x = $GLOBALS['EVENTS'][$i] ?? NULL;
	if( !$x ){ ?>

		<br/><br/>
		<h1 class="text-center font-weight-bold">404 Not Found</h1>

	<?php } else { ?>

		<h3 class="mb-4">Event Details</h3>

	<?php
		foreach ($x as $k => $u) {
	?>
		<div class="bg-light p-4 border rounded mb-4">
			<h5 class="text-capitalize font-weight-bold"><?= $k ?></h5>
			<hr/>
			<p><?= $u ?></p>
		</div>
	<?php }}

} else { ?>

	<br/><br/>
	<h1 class="text-center font-weight-bold">404 Not Found</h1>

<?php }

	$o = ob_get_clean();
?>
<!DOCTYPE html>
<html>
<head>
	<script src="assets/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/bootstrap.min.css" />

	<title><?= @$x['title'] ? 'Display: ' . $x['title'] : 'Not Found' ?></title>
</head>
<body>
	<div class="w-100 mx-auto p-4" style="max-width: 500px;">
		<?= $o ?>
	</div>
	<center>
		<small>&copy; Taskii 2020</small>
	</center><br/><br/>
</body>
</html>