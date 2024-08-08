<?php include("header.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="login.css">
    <title>Student Login Page</title>
    <style>
        .forgot{
            display: flex;
            justify-content: center;
        
        }

        .forgot > a{
            padding-top: 25px;
        }
    </style>
</head>


<body>
        <div class="login-box">
            <form action="student_validate.php" method="post">
                <h1>Student Login</h1>

                <div class="textbox">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <input type="text" placeholder="Username" name="enrollment_id" value="">
                </div>

                <div class="textbox">
                    <i class="fa fa-lock" aria-hidden="true"></i>
                    <input type="password" placeholder="Password" name="password" value="">
                   
                </div>

                <input class="button" type="submit" name="login" value="Sign In">
                <div class="forgot">
                <a href="http://localhost/test/login/Forgetpass.php">Forgot password</a>
                </div>
            </form>
        </div>
    
    <footer class="footer">
        Alpha Institute
    </footer>
</body>

</html>
