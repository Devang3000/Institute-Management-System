<?php
include("header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="login.css">  
    <title>Reset Password</title>
</head>
<body>

<?php

require '../connection.php'; 



if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    // Verify the token
    $stmt = $conn->prepare("SELECT * FROM enrollment WHERE reset_token = ? AND token_expiry > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch();
    
    if ($user) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            
            // Update the password
            $stmt = $conn->prepare("UPDATE Studentlogin SL
            INNER JOIN enrollment en ON en.enrollment_id = SL.enrollment_id
            SET SL.password = ?, en.reset_token = NULL, en.token_expiry = NULL
            WHERE en.reset_token = ?"
        );
            if ($stmt->execute([$password, $token])) {
                echo "<script>alert('Your password has been reset successfully')</script>";
            } else {
                echo "<script>alert('Failed to reset password. Please try again')</script>";
            }
        }
    } else {
        echo "Invalid or expired token.";
    }
} else {
    echo "Token is missing.";
}
?>

<!-- Form -->
<?php if (isset($user) && $user): ?>
    <div class = "login-box">
    <form action="reset_password.php?token=<?php echo htmlspecialchars($token); ?>" method="post">

        <h1>New password</h1>
        <div class = "textbox">
        <i class="fas fa-lock"></i>
        <input type="password" id="password" name="password" required>
        <button type="submit">Reset Password</button>
        </div>
        <button class = "button" type="submit">Submit</button>
    </form>
    </div>
<?php endif; ?>

</body>
<footer class="footer">
        Alpha Institute
    </footer>
</html>
