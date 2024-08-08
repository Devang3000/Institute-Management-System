<?php

include("../header.php");
include("../connection.php");
error_reporting(E_ALL);

$admin_logged_in = isset($_SESSION["admin_logged_in"]) && $_SESSION["admin_logged_in"];

if ($admin_logged_in) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
        $course_name = trim($_POST['course_name']);
        $description = trim($_POST['description']);
        $registration = floatval($_POST['registration']);
        $tuition = floatval($_POST['tuition']);
        $lab = floatval($_POST['lab']);

        if (!empty($course_name) && !empty($description) && $registration > 0 && $tuition > 0 && $lab > 0) {
            // Use prepared statements to prevent SQL injection
            $stmt_courses = $conn->prepare("INSERT INTO courses (course_name, description) VALUES (?, ?)");
            $stmt_courses->bind_param("ss", $course_name, $description);

            if ($stmt_courses->execute()) {
                // Get the last inserted ID
                $course_id = $conn->insert_id;

                $stmt_fees = $conn->prepare("INSERT INTO fees (course_id, registration, tuition, lab) VALUES (?, ?, ?, ?)");
                $stmt_fees->bind_param("iddd", $course_id, $registration, $tuition, $lab);

                if ($stmt_fees->execute()) {
                    echo "<script>alert('Course added successfully!');</script>";
                    echo '<meta http-equiv="refresh" content="0; url=courses.php" />';
                } else {
                    echo "<script>alert('Failed to add fees. Please try again.');</script>";
                }

                $stmt_fees->close();
            } else {
                echo "<script>alert('Failed to add course. Please try again.');</script>";
            }

            $stmt_courses->close();
        } else {
            echo "<script>alert('Please fill in all fields with valid data.');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Update Course Details</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");
        .container {
            position: relative;
            max-width: 350px;
            width: 100%;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .container header {
            font-size: 1.5rem;
            color: #333;
            font-weight: 500;
            text-align: center;
        }
        .container .form {
            margin-top: 30px;
        }
        .form .input-box {
            width: 100%;
            margin-top: 20px;
        }
        .input-box label {
            color: #333;
        }
        .form :where(.input-box input, .select-box) {
            position: relative;
            height: 50px;
            width: 100%;
            outline: none;
            font-size: 1rem;
            color: #707070;
            margin-top: 8px;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 0 15px;
        }
        .input-box input:focus {
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
        }
        .form .column {
            display: flex;
            column-gap: 15px;
        }
        .form .mode-box {
            margin-top: 20px;
        }
        .mode-box h3 {
            color: #333;
            font-size: 1rem;
            font-weight: 400;
            margin-bottom: 8px;
        }
        .form :where(.mode-option, .mode) {
            display: flex;
            align-items: center;
            column-gap: 50px;
            flex-wrap: wrap;
        }
        .form .mode {
            column-gap: 5px;
        }
        .mode input {
            accent-color: rgb(130, 106, 251);
        }
        .form :where(.mode input, .mode label) {
            cursor: pointer;
        }
        .mode label {
            color: #707070;
        }
        .address :where(input, .select-box) {
            margin-top: 15px;
        }
        .select-box select {
            height: 100%;
            width: 100%;
            outline: none;
            border: none;
            color: #707070;
            font-size: 1rem;
        }
        .form button {
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
        }
        .form button:hover {
            background: rgb(88, 56, 250);
        }
        @media screen and (max-width: 500px) {
            .form .column {
                flex-wrap: wrap;
            }
            .form :where(.mode-option, .mode) {
                row-gap: 15px;
            }
        }
        .headerf {
            font-size: 1.5rem;
            color: #333;
            font-weight: bold;
            text-align: center;
            display: block;
            margin-bottom: 50px;
        }
    </style>
</head>
<body>

<section class="container">
    <form class="form" method="POST" action="">
        <div class="headerf">ADD Course Details</div>

        <div class="input-box">
            <label>Course Name</label>
            <input type="text" name="course_name" required>
        </div>

        <div class="input-box">
            <label>Description</label>
            <input type="text" name="description" required>
        </div>

        <div class="input-box">
            <label>Registration Fee</label>
            <input type="number" name="registration" required>
        </div>

        <div class="input-box">
            <label>Tuition Fee</label>
            <input type="number" name="tuition" required>
        </div>

        <div class="input-box">
            <label>Lab Fee</label>
            <input type="number" name="lab" required>
        </div>

        <button class="form" type="submit" name="update">Submit</button>
    </form>
</section>
</body>
</html>

<?php
} else {
    echo '<script>alert("Login as admin to continue");window.location.href="../login/admin.php";</script>';
}
include("../footer.php");
?>
