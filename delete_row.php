<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $rowId = intval($_POST['id']);

   include "connection.php";

   $sql = "DELETE FROM enquiry WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $rowId);
    mysqli_stmt_execute($stmt);
    if ($stmt) {
        echo "Row deleted successfully";
    ?>
       <meta http-equiv="refresh" content="0; url=http://localhost/test/display.php" />
        <?php
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Error: Could not prepare statement";
}

mysqli_close($conn);
 
} else {
    echo "Invalid request";
}
?>
