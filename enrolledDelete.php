<?php
include "connection.php";

$id = $_GET['id'];

$sql_query = "DELETE FROM enrollment WHERE enq_id = '$id'";
$data = mysqli_query($conn,$sql_query);

if($data)
{
    echo "<script>alert('Record Deleted')</script>";
    ?>
    <meta http-equiv = "refresh" content = "0; url = http://localhost/test/enrolledstudents.php" />


    <?php
}
else
{
    echo "<script>alert('Record Not Delete')</script>";
}
?>