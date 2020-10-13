<?php
        session_start();
        require 'db_connection.php';
        $db = DB();
        require 'operation.php';
        $app = new Operation($db);
        $user = $app->UserDetails($_SESSION['user_id']);
        $error_message = '';
        if (isset($_POST['btnValidate'])) {
            $code = $_POST['code'];
            if ($code == "") {
                $error_message = 
                       'Please enter authentication code to validated!';
            }
            else
            {
                if($code==$_SESSION['otp'])
                {
                    
                    header("Location: profile.php");
                    //echo '<h2>You have entered 2FA secret code correctly.Login Successful!</h2>';
                    //$error_message = 'You have entered 2FA secret code correctly.Login Successful!';
                }
                else
                {
                    $error_message = 'You have entered Wrong 2FA secret code.Login Failed!';
                    //exit();
                }
            }
        }
       ?>
        
        
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Validate Login</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <div class="row jumbotron">
        <div class="col-md-12">
            <h2>
                We have sent a secret code to your email.<br>Please check your email and insert the code in the following Input Field:
            </h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 col-md-offset-3 well">
            <h4>Two Factor Authentication</h4>

            <form method="post" action="validate_login.php">
                <?php
                if ($error_message != "") {
                    echo '<div class="alert alert-danger"><strong>Error: </strong> ' . $error_message . '</div>';
                }
                ?>
                <div class="form-group">
                    <input type="text" name="code" placeholder="Enter Secret Code Here" class="form-control">
                
                    <button type="submit" name="btnValidate" class="btn btn-primary">Verify code</button>
                </div>
            </form>
<!--
            <div class="form-group">
                Click here to <a href="index.php">Login</a> if you have already registered your account.
            </div>  -->
        </div>
    </div>
</div>

</body>
</html>
