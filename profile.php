<?php

// Start Session
session_start();

// check user login
if(empty($_SESSION['user_id']))
{
    header("Location: index.php");
}

// Load PHP files for Database connection
require 'db_connection.php';
$db = DB();

// Load the operation implementations ( i.e., Operation class )
require 'operation.php';
$app = new Operation($db);
$user = $app->UserDetails($_SESSION['user_id']);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link rel="stylesheet" 
href=https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css >
</head>
<body>

<div class="container">
    
    <div class="col-md-12">
        <h2>
            Google 2-FA Login Successful!
        </h2>
    
    </div>
    <div class="row">
        <div class="col-md-5 col-md-offset-3 well">
            <h2>User Profile</h2>
            <h4>Welcome <?php echo $user->name; ?></h4>
            <p>Account Details:</p>
            <p>Name: <?php echo $user->name; ?></p>
            <p>Username <?php echo $user->username; ?></p>
            <p>Email <?php echo $user->email; ?></p>
            <br>
            Click here to <a href="logout.php">Logout</a>
        </div>
    </div>
</div>

</body>
</html>
