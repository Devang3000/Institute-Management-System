<?php
include("header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="login.css">    
    <title>Forgot Password</title>

</head>
<body>
    <div class = "login-box">
    <form action="forgot_password.php" method="post">
        <h1>Reset Password</h1>
        <div class = "textbox">
        <i class="fa fa-envelope"></i>
        <input type="email" id = "email" placeholder="Email address" name="email" required>
        </div>

        <button class = "button" type="submit">Submit</button>

    </form>
    </div>

</body>
<footer class="footer">
        Alpha Institute
    </footer>
</html>
