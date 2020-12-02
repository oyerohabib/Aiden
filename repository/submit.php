<?php

// Include necessary files

require_once( 'sources/bootstrap.php' );

// Redirect to /login is not logged in
if( empty($_SESSION['User']) ){
	header('Location: login.php');
	exit();
}

// Convert fields into variables
extract($_POST);

if( !empty($add) ){

	$msg = '';

	// Validate title
	if( empty($title) || !preg_match('/^[\w_ -]{5,}$/', $title) ){
		$msg .= '<font color="red">Invalid title, can contain alphanumeric, hyphen (-) or underscore (_) and must be a minimum of 5 chars</font>';
	}

	// Validate organisers
	if( empty($organisers) || !preg_match('/^[\w_ -]{5,}$/', $organisers) ){
		$msg .= '<font color="red">Invalid organisers, can only contain alphanumeric, hyphen (-) or underscore (_) with a minimum of 5 chars</font>';
	}

	// Validate date
	if( empty($date) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) ){
		$msg = '<font color="red">Invalid date</font>';
	}

	// Validate time
	if( empty($time) || !preg_match('/^\d{2}:\d{2}$/', $time) ){
		$msg = '<font color="red">Invalid time, supply a valid time with this format HH:MM</font>';
	}

	// Validate location
	if( empty($location) || str_word_count($location)>25 ){
		$msg = '<font color="red">Location cannot be empty with maximum of 25 words</font>';
	}

	// Validate description
	if( empty($description) || strlen($description)<100 ){
		$msg = '<font color="red">Description cannot be empty and must be a minimum of 100 chars</font>';
	}

	// Save the record if no error ocurred
	if( !$msg ) {
		unset($_POST['add']);
		$GLOBALS['EVENTS'][] = $_POST;
		if( save() )
			$msg = '<font color="green">Record added successfully</font><script>setTimeout(function(){location.replace(location.href);}, 2000);</script>';
		else
			$msg = '<font color="red">Could not save your record please try again</font>';
	}

}

?>

<!DOCTYPE html>
<html>
<head>
	<script src="assets/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="assets/font-awesome.min.css" />

	<title>Add a new Record</title>
</head>
<body>
	<div class="p-4 w-100 mx-auto" style="max-width: 600px;">
		<form method="post">
			<h4 class="mb-4">Add new Event</h4>
			<hr/>
			<p><?= ($msg ?? ''); # Print a message if there is one  ?></p>

			<label>Title</label>
			<input name="title" required value="<?= $title ?? '' ?>" class="form-control" /><br/>

			<label>Organisers</label>
			<input name="organisers" required value="<?= $organisers ?? '' ?>" class="form-control" /><br/>

			<label>Date</label>
			<input type="date" name="date" required value="<?= $date ?? '' ?>" class="form-control" /><br/>

			<label>Time</label>
			<input type="time" name="time" required value="<?= $time ?? '' ?>" class="form-control" /><br/>

			<label>Location</label>
			<input name="location" required value="<?= $location ?? '' ?>" class="form-control" /><br/>

			<label>Description</label>
			<textarea name="description" required min="200" class="form-control"><?= $description ?? '' ?></textarea><br/>
			
			<br/>
			<button name="add" value="1" type="submit" class="btn btn-primary">
				CREATE
			</button>
		</form>
	</div>

	<br/>
	<center>
		<small>&copy; Taskii 2020 . <a href="logout.php">Logout</a></small>
	</center><br/><br/>
</body>
</html>