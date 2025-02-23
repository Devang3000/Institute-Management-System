<?php
include("header.php");
// Start the session to access session variables

// Check if logout request is made
if (isset($_GET['logout'])) {
    logout();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="login.css">
    <title>Login Page</title>
</head>

<body>
        <div class="login-box">
            <form action="validate.php" method="post">
                <h1>Admin Login</h1>

                <div class="textbox">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <input type="text" placeholder="Username" name="username" value="">
                </div>

                <div class="textbox">
                    <i class="fa fa-lock" aria-hidden="true"></i>
                    <input type="password" placeholder="Password" name="password" value="">
                </div>

                <input class="button" type="submit" name="login" value="Sign In">
            </form>
        </div>
    
    <footer class="footer">
        Alpha Institute
    </footer>
</body>

</html>
