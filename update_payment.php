<?php
include "connection.php"; // Include your database connection file
session_start(); // Ensure session is started

$admin_logged_in = isset($_SESSION["admin_logged_in"]) && $_SESSION["admin_logged_in"];

if ($admin_logged_in) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $enrollment_id = intval($_POST['enrollment_id']); // Ensure enrollment_id is an integer
        $payment = floatval($_POST['payment']); // Ensure payment is a float

        // Fetch current unpaid amount
        $sql_select = "SELECT unpaid FROM enrollment WHERE enrollment_id = ?";
        $stmt_select = mysqli_prepare($conn, $sql_select);
        
        if ($stmt_select) {
            mysqli_stmt_bind_param($stmt_select, "i", $enrollment_id);
            mysqli_stmt_execute($stmt_select);
            $result_select = mysqli_stmt_get_result($stmt_select);
            $row = mysqli_fetch_assoc($result_select);
            
            if ($row) {
                $unpaid = $row['unpaid'];

                // Calculate new unpaid amount
                $new_unpaid = $unpaid - $payment;

                // Update the unpaid amount in the database
                $sql_update = "UPDATE enrollment SET unpaid = ? WHERE enrollment_id = ?";
                $stmt_update = mysqli_prepare($conn, $sql_update);

                // Insert payment record into the payments table
                $sql_insert_payment = "INSERT INTO payments (enrollment_id, payment_amount, payment_date) VALUES (?, ?, NOW())";
                $stmt_insert_payment = mysqli_prepare($conn, $sql_insert_payment);

                if ($stmt_update && $stmt_insert_payment) {
                    mysqli_stmt_bind_param($stmt_update, "di", $new_unpaid, $enrollment_id);
                    mysqli_stmt_bind_param($stmt_insert_payment, "id", $enrollment_id, $payment);

                    mysqli_begin_transaction($conn); // Start a transaction

                    // Execute both update and insert queries within the same transaction
                    if (mysqli_stmt_execute($stmt_update) && mysqli_stmt_execute($stmt_insert_payment)) {
                        mysqli_commit($conn); // Commit the transaction if both queries are successful
                        echo "<script>alert('Payment updated successfully.');window.location.href='enrolledstudents.php';</script>";
                    } else {
                        mysqli_rollback($conn); // Rollback the transaction if any query fails
                        echo "<script>alert('Error updating payment.');window.location.href='enrolledstudents.php';</script>";
                    }
                } else {
                    echo "<script>alert('Error preparing SQL statements.');window.location.href='enrolledstudents.php';</script>";
                }

                mysqli_stmt_close($stmt_update);
                mysqli_stmt_close($stmt_insert_payment);
            } else {
                echo "<script>alert('Enrollment ID not found.');window.location.href='enrolledstudents.php';</script>";
            }

            mysqli_stmt_close($stmt_select);
        } else {
            echo "<script>alert('Error preparing select statement.');window.location.href='enrolledstudents.php';</script>";
        }
    }
    mysqli_close($conn);
} else {
    echo '<script>alert("Login as admin to continue");window.location.href="login.php";</script>';
}
?>
