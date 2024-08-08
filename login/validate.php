<?php
 
 include_once __DIR__ . '/../connection.php';
  
function test_input($data) {
     
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
  
if ($_SERVER["REQUEST_METHOD"] == "POST") {
     
    $username = test_input($_POST["username"]);
    $password = test_input($_POST["password"]);
    $stmt = $conn->prepare("SELECT * FROM adminlogin");
    $stmt->execute();
    $resultSet = $stmt->get_result();
    $users = $resultSet->fetch_all(MYSQLI_ASSOC);
     
    foreach($users as $user) {
         
        if(($user['username'] == $username) && 
            ($user['password'] == $password)) {
                      
                
                session_start();
                $_SESSION["admin_logged_in"] = true;

                header("location: http://localhost/test/home.php");
        }
        else {
           

            echo "<script>alert('Invalid username or password'); window.location.href = 'http://localhost/test/login/admin.php';</script>";
        }
    }
}
?>