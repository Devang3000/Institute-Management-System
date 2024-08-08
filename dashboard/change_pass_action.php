<?php
session_start();
include '../connection.php';

$enrollment_id = $_POST['username'];  // Using enrollment_id as identifier
$password = $_POST['password'];
$newpassword = $_POST['newpassword'];
$confirmnewpassword = $_POST['confirmnewpassword'];

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if enrollment_id exists
$stmt = $conn->prepare("SELECT password FROM studentlogin WHERE enrollment_id=?");
$stmt->bind_param("s", $enrollment_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 0) {
    echo "The enrollment ID you entered does not exist";
    $stmt->close();
    $conn->close();
    exit();
}

$stmt->bind_result($stored_password);
$stmt->fetch();

if ($password !== $stored_password) {
    echo "You entered an incorrect password";
    $stmt->close();
    $conn->close();
    exit();
}

$stmt->close();

if ($newpassword !== $confirmnewpassword) {
    echo "Passwords do not match";
    $conn->close();
    exit();
}

// Update password
$stmt = $conn->prepare("UPDATE studentlogin SET password=? WHERE enrollment_id=?");
$stmt->bind_param("ss", $newpassword, $enrollment_id);
if ($stmt->execute()) {
    echo '<scirpt> alert("Congratulations! You have successfully changed your password.")</script>';
} else {
    echo "Error updating password: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
