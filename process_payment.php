<?php
session_start();
require 'razorpay\Razorpay.php'; // Razorpay PHP SDK

include("connection.php");

use Razorpay\Api\Api;

$api = new Api('rzp_test_b4ErrgywyBpny5', 'W2pwQokRxN6FoAVhBu4OEbFS');

$id = $_SESSION["user"]; // User's enrollment ID from session

// Validate and sanitize input
$amount = filter_var($_POST['amount'], FILTER_SANITIZE_NUMBER_INT);
$payment_id = $_POST['razorpay_payment_id'];

if ($amount <= 0 || empty($payment_id)) {
    die("Invalid input.");
}

// Fetch user details and unpaid amount
$id = intval($id);
$sql_query = "SELECT e.total_fees, (SELECT SUM(payment_amount) FROM payments WHERE enrollment_id = '$id') as total_paid 
              FROM enrollment e 
              WHERE e.enrollment_id = '$id'";
$data = mysqli_query($conn, $sql_query);
$user = mysqli_fetch_assoc($data);

if (!$user) {
    die("User not found.");
}

$total_fees = $user['total_fees'];
$total_paid = $user['total_paid'];
$remaining_fees = $total_fees - $total_paid;

if ($amount > $remaining_fees) {
    die("Amount exceeds remaining fees.");
}

try {
    // Fetch the payment details from Razorpay to verify the payment
    $payment = $api->payment->fetch($payment_id);

    if ($payment['status'] == 'authorized') {
        // Update database
        $new_total_paid = $total_paid + $amount;
        $sql_update = "UPDATE enrollment SET unpaid = unpaid - $amount WHERE enrollment_id = $id";
        mysqli_query($conn, $sql_update);

        $sql_insert_payment = "INSERT INTO payments (enrollment_id, payment_amount, payment_date, payment_id) VALUES ($id, $amount, NOW(), '$payment_id')";
        mysqli_query($conn, $sql_insert_payment);

        echo "Payment successful.";
        $delay = new DateTime('+3 seconds');
        echo '<script>window.location.href="http://localhost/test/dashboard/student_dashboard.php";</script>';
    } else {
        echo "Payment failed.";
    }
} catch (Exception $e) {
    echo "Payment failed: " . $e->getMessage();
}

mysqli_close($conn);
?>
