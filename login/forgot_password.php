<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';


require '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

   
    $stmt = $conn->prepare("SELECT * FROM enquiry e 
        INNER JOIN enrollment en ON en.enq_id = e.id 
        WHERE e.email = ? AND en.enrollment_id IS NOT NULL");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Generate a unique token
        $token = bin2hex(random_bytes(50));

        // Store the token in the database
        $stmt = $conn->prepare("UPDATE enrollment en 
            INNER JOIN enquiry e ON en.enq_id = e.id 
            SET en.reset_token = ?, en.token_expiry = DATE_ADD(NOW(), INTERVAL 1 HOUR) 
            WHERE e.email = ?");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();

       
        $resetLink = "http://localhost/test/login/reset_password.php?token=$token";

      
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.office365.com';                
            $mail->SMTPAuth   = true;
            $mail->Username   = '*********************';
            $mail->Password   = '*******';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
            $mail->Port       = 587; // TCP port to connect to

        
            $mail->setFrom('devangpathak3@outlook.com', 'Alpha institute');
            $mail->addAddress($email);

      
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body    = "Click the following link to reset your password: <a href='$resetLink'>$resetLink</a>";
            $mail->AltBody = "Click the following link to reset your password: $resetLink";

            $mail->send();
            echo "<script>alert('A password reset link has been sent to your email');window.location.href='http://localhost/test/login/Forgetpass.php';</script>";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
      echo "<script>alert('No user found with that email address');window.location.href='http://localhost/test/login/Forgetpass.php';</script>"; 
      
    }
    
}
?>


