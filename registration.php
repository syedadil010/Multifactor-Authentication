		<?php
		// Start Session
		session_start();

		// Load PHP files for Database connection
		require 'db_connection.php';
		$db = DB();

		// Load the operation implementations ( i.e., Operation class )
		require 'operation.php';
		$app = new Operation($db);

		require_once __DIR__ . '/PHPGangsta/GoogleAuthenticator.php';
		$pga = new PHPGangsta_GoogleAuthenticator();
		$secret = $pga->createSecret();

		$register_error_message = '';

		// check Register request
		if (!empty($_POST['btnRegister'])) {
			if ($_POST['name'] == "") {
				$register_error_message = 'Name field is required!';
			} else if ($_POST['email'] == "") {
				$register_error_message = 'Email field is required!';
			} else if ($_POST['username'] == "") {
				$register_error_message = 'Username field is required!';
			} else if ($_POST['password'] == "") {
				$register_error_message = 'Password field is required!';
			} else if ($_POST['phone_no'] == "") {
				$register_error_message = 'Phone Number field is required!';
			} else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
				$register_error_message = 'Invalid email address!';
			} else if ($app->isEmail($_POST['email'])) {
				$register_error_message = 'Email is already in use!';
			} else if ($app->isUsername($_POST['username'])) {
				$register_error_message = 'Username is already in use!';
			} else {
				$user_id = $app->Register($_POST['name'], $_POST['email'], $_POST['username'], $_POST['password'], $secret, $_POST['phone_no']);
				// set session and redirect user to the profile page
				$_SESSION['user_id'] = $user_id;
				header("Location: confirm_google_auth.php");
			}
		}
		?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <link rel="stylesheet" 
href=https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css >
</head>
<body>

<div class="container">
        <div>
            <h2>
                Example: Google Two factor authentication using PHP & MySQL
            </h2>
        </div>
       <div class="row">
        <div class="col-md-5 col-md-offset-3 well">
		<h4>Register</h4>
		 <?php
		  if ($register_error_message != "") {
			echo '<div class="alert alert-danger"><strong>Error: </strong> ' . 
			$register_error_message . '</div>';
		  }
		 ?>
		 <form action="registration.php" method="post">
		  <div class="form-group">
			<label for="">Name</label>
			 <input type="text" name="name" class="form-control"/>
			</div>
			<div class="form-group">
			 <label for="">Email</label>
			 <input type="email" name="email" class="form-control"/>
			</div>
			<div class="form-group">
			 <label for="">Username</label>
			 <input type="text" name="username" class="form-control"/>
			</div>
			<div class="form-group">
			 <label for="">Password</label>
			 <input type="password" name="password" class="form-control"/>
			</div>
			<div class="form-group">
			 <label for="">Phone Number</label>
			 <input type="tel" name="phone_no" class="form-control"/>
			</div>
			<div class="form-group">
			 <input type="submit" name="btnRegister" class="btn btn-primary" value="Register"/>
			</div>
		</form>
		 <div class="form-group">
		  Click here to <a href="index.php">Login</a> 
		  if you have already registred your account.
		 </div>
        </div>
	   
	   </div>
</div>

</body>
</html>