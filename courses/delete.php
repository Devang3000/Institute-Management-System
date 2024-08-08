<?php
include("../connection.php");
session_start();

$admin_logged_in = isset($_SESSION["admin_logged_in"]) && $_SESSION["admin_logged_in"]; 
if($admin_logged_in){


$id = $_POST['delete'];

$sql_query = "DELETE FROM courses WHERE course_id = '$id'";
$sql_fees = "DELETE FROM Fees WHERE course_id = '$id'";
$data = mysqli_query($conn,$sql_query);
$data2 = mysqli_query($conn,$sql_fees);

if($data&&$data2)
{
    echo "<script>alert('course Deleted')</script>";
    ?>
    <meta http-equiv = "refresh" content = "0; url = http://localhost/test/courses/courses.php" />


    <?php
}
else
{
    echo "<script>alert('course Not Delete')</script>";
}
}
else{
    echo '<script>"Login as admin to access this file."</script>';
    echo '<script>window.location.href="http://localhost/test/home.php";</script>';
}
?>