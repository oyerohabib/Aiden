<?php

// Include necessary files

require_once( 'sources/bootstrap.php' );

// Redirect to /index if user is logged in
if( !empty($_SESSION['User']) ){
	header('Location: submit.php');
	exit();
}

// Convert fields into variables
extract($_POST);

// Check if form is submitted
if( !empty($login) ){

	// Confirm the submission is valid (not empty)
	if( !empty($u_name) && !empty($u_pass) ){
		// Validate the login details
		if( @$GLOBALS['USERS'][$u_name] && @$GLOBALS['USERS'][$u_name]['password']==$u_pass ){
			// Set session user to logged in status
			$_SESSION['User'] = $u_name;
			
			// Update last login
			$GLOBALS['USERS'][$u_name]['last_login'] = Date('Y-m-d H:i:s');
			save();

			header('Location: submit.php');
			exit();
		} else {
			$msg = '<font color="red">Invalid username or password.</font>';
		}
	} else {
		$msg = '<font color="red">Fill the form completely and try again.</font>';
	}

}

?>

<!DOCTYPE html>
<html>
<head>
	<script src="assets/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="assets/font-awesome.min.css" />

	<title>Login</title>
</head>
<body>
	<div class="w-100 p-4 mx-auto" style="max-width: 500px;">
		<form method="post">
			<h4 class="mb-4">Admin Login</h4>
			<hr/>
			<p><?= ($msg ?? ''); # Print a message if there is one  ?></p>

			<label>Username</label>
			<input class="form-control" name="u_name" required /><br/>
			
			<label>Password</label>
			<input class="form-control" type="password" name="u_pass" required /><br/>
			
			<button type="submit" name="login" value="1" class="btn btn-primary">
				LOGIN
			</button>
		</form>
	</div>

	<br/>
	<center>
		<small>&copy; Taskii 2020</small>
	</center><br/><br/>
</body>
</html>