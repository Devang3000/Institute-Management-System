<?php
 
 include_once __DIR__ . '/../connection.php';
  
function test_input($data) {
     
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
  
if ($_SERVER["REQUEST_METHOD"] == "POST") {
     
    $enrollment_id = test_input($_POST["enrollment_id"]);
    $password = test_input($_POST["password"]);
    $stmt = $conn->prepare("SELECT * FROM studentLogin");
    $stmt->execute();
    $resultSet = $stmt->get_result();
    $users = $resultSet->fetch_all(MYSQLI_ASSOC);
     
    foreach($users as $user) {
         
        if(($user['enrollment_id'] == $enrollment_id) && 
            ($user['password'] == $password)) {
                      
                
                session_start();
                $_SESSION["student_logged_in"] = true;
                $_SESSION["user"]=$enrollment_id;
                

                header("location: http://localhost/test/home.php");
        }
        else {
           

            echo "<script>alert('Invalid username or password'); window.location.href = 'http://localhost/test/login/student.php';</script>";
        }
    }
}
?>