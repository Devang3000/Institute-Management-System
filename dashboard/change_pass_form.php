<?php include('../header.php');?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password Change</title>
    <style>
        /* Import Google font - Poppins */
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
        }

        .container {
            max-width: 300px;
            width: 100%;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin: 50px auto; /* Ensure spacing from the header and footer */
        }

        .container header {
  font-size: 1.5rem;
  color: #333;
  font-weight: 500;
  text-align: center;
}

        .headerf {
      font-size: 1.5rem;
      color: #333;
      font-weight: bold; /* Make the text bold */
      text-align: center; /* Center the text */
      display: block;
      margin-bottom: 50px; /* Add space below the header */
    }

        .input-box {
            width: 100%;
            margin-top: 20px;
        }

        .input-box label {
            color: #333;
            display: block;
            margin-bottom: 8px;
        }

        .input-box input {
            height: 50px;
            width: 100%;
            outline: none;
            font-size: 1rem;
            color: #707070;
            margin-top: 8px;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 0 10px;
        }

        .input-box input:focus {
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
        }

        button {
            height: 55px;
            width: 100%;
            color: #fff;
            font-size: 1rem;
            font-weight: 400;
            margin-top: 30px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            background: rgb(130, 106, 251);
            border-radius: 6px;
        }

        button:hover {
            background: rgb(88, 56, 250);
        }

        /* Responsive */
        @media screen and (max-width: 500px) {
            .container {
                padding: 15px;
            }

            button {
                height: 45px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        
        <form method="POST" action="change_pass_action.php">
        <div class="headerf">change password form</div> 
            <div class="input-box">
                <label for="username">Enter your Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-box">
                <label for="password">Enter your existing password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-box">
                <label for="newpassword">Enter your new password</label>
                <input type="password" id="newpassword" name="newpassword" required>
            </div>
            <div class="input-box">
                <label for="confirmnewpassword">Re-enter your new password</label>
                <input type="password" id="confirmnewpassword" name="confirmnewpassword" required>
            </div>
            <button type="submit">Update Password</button>
        </form>
    </div>

    <?php include('../footer.php');?>
</body>
</html>
