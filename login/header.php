<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Alpha Institute</title>
    <link rel="icon" type="image/x-icon" href="../images\icon_black.png">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #header {
            background-color: #000099;
            color: white;
            text-align: left;
            width: 100%;
            padding: 30px 0;
            transition: all 0.2s ease-in-out;
            z-index: 999;
            top: 0;
            position: sticky;
            display: flex;
            align-items: center;
        }

        nav {
            background-color: #333;
            width: 100%;
            position: sticky;
            top: 0px;
            z-index: 998;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav ul li {
            margin: 0;
            float:left;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: block;
            border-radius: 20px;
        }

        nav ul li a:hover {
            background-color: #575757;
            border-radius: 50px;
            color: white;
        }

        .container {
            display: flex;
            width: 80%;
            margin: 1em 0;
        }

        main {
            flex: 3;
            padding: 2em;
            margin: 10px;
            background-color: #f4f4f4;
            margin-right: 1em;
        }

        

        .logout-link {
            color: whitesmoke;
            text-decoration: none;
            background-color: red;
            border-radius: 17px;
            border: 1px solid #f84609;
        }

        .logout-link:hover {
            background-color: #e1c4b7;
        }

        .login-link {
            color: whitesmoke;
            text-decoration: none;
            background-color: #50C878;
            border: 1px solid #f84609;
            border-radius: 15px;
            margin: 3px;
        }

        .login-link:hover {
            background-color: #7FFFD4;
        }

        .header-content {
            display: flex;
            align-items: center;
            transition: all 0.2s ease-in-out;
        }

        .header-content img {
            margin-right: 10px;
            margin-left: 5px;
            width: 120px;
            height: 120px;
            
        }

        h1 {
            padding-top: 20px;
            font-size: 2em;
            
        }

        h5 {
            font-size: 1em;
            
        }

        .small-header .header-content img {
            width: 40px;
            height: 40px;
           
        }

        .small-header h1 {
            font-size: 1em;
            
        }

        .small-header h5 {
            font-size: 0.5em;
            
        }

        .small-header {
            padding: 5px 0;
            height: 50px;
            z-index: 999;
         
        }
        #icon{
            width: 100px;
            height : 100px;
        }
        #headericon{
            color:white;
            justify-content: center;
            margin-bottom: 10px;
            top:0;
            text-decoration: none;
            font-family: sans-serif;
        }
    </style>
</head>
<body>
<?php
session_start();

$admin_logged_in = isset($_SESSION["admin_logged_in"]) && $_SESSION["admin_logged_in"];
$student_logged_in = isset($_SESSION["student_logged_in"]) && $_SESSION["student_logged_in"];

function renderDashboard($current_page){
    $is_active = ($current_page == 'admin_dashboard.php') ? 'current-page' : '';
    echo '<li class="' . $is_active . '"><a href="/dashboard/admin_dashboard.php">Admin Dashboard</a></li>';
}

function viewDetails($current_page) {
    $is_active = ($current_page == 'student_dashboard.php') ? 'current-page' : '';
    echo '<li class="' . $is_active . '"><a href="/dashboard/student_dashboard.php">Dashboard</a></li>';
}

function logout() {
    $_SESSION = array();
    session_destroy();
    header("Location: http://localhost/test/home.php");
    exit;
}

if (isset($_GET['logout'])) {
    logout();
}


?>


<!--<div id="header">
    <header class="header-content">
        <img src="http://localhost/test/images/icon.png" alt="Payment Icon">
        <div>
            <h1>Alpha Institute</h1>
            <h5>Work is Worship!</h5>
        </div>
    </header>
</div> -->

<nav>
    <ul>
    <div>
    <li><img src="http://localhost/test/images/icon.png" alt="Payment Icon" id = 'icon'></li>
    <li><div id = 'headericon'>
            <h1>Alpha Institute</h1>
            <h5>Work is Worship!</h5>
        </div></li>
        </div>
        <div class="nav-links">
            <li><a href="http://localhost/test/home.php">Home</a></li>
            <li><a href="http://localhost/test/about.php">About</a></li>
            <li><a href="http://localhost/test/services.php">Courses</a></li>
            <li><a href="http://localhost/test/newinq.php">Enquiry</a></li>
            
        </div>
        <div class="auth-links">
            <?php if ($admin_logged_in || $student_logged_in) {
                echo '<li><a href="http://localhost/test/home.php?logout=true" class="logout-link">Logout</a></li>';
            } else {
                echo '<li><a href="http://localhost/test/login/admin.php" class="login-link">Admin Login</a></li>';
                echo '<li><a href="http://localhost/test/login/student.php" class="login-link">Student Login</a></li>';
            } ?>
        </div>
    </ul>
</nav>

<script>
    window.onscroll = function() {
        var header = document.getElementById("header");
        if (document.documentElement.scrollTop > 0.5) {
            header.classList.add("small-header");
        } else {
            header.classList.remove("small-header");
        }
    };
</script>

</body>
</html>
