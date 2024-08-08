<?php
include("../header.php");
include("../connection.php");
error_reporting(E_ALL);

$admin_logged_in = isset($_SESSION["admin_logged_in"]) && $_SESSION["admin_logged_in"];

if ($admin_logged_in) {

$id = $_GET['course_id'];

// Validate input
$id = intval($id);

$sql_query = "SELECT * FROM courses c 
              JOIN fees f ON c.course_id = f.course_id 
              WHERE c.course_id = '$id'";
$data = mysqli_query($conn, $sql_query);

if ($data && mysqli_num_rows($data) > 0) {
    $result = mysqli_fetch_assoc($data);
} else {
    die("Record not found.");
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
        <form class="form" method="POST">
            <div class="headerf">Update Course Details</div> 

            <div class="input-box">
                <label>Course Name</label>
                <input type="text" value="<?php echo $result['course_name']; ?>" name="course_name" required>
            </div>

            <div class="input-box">
                <label>Description</label>
                <input type="text" value="<?php echo $result['description']; ?>" name="description" required>
            </div>

            <div class="input-box">
                <label>Registration Fee</label>
                <input type="number" value="<?php echo $result['registration']; ?>" name="registration" required>
            </div>

            <div class="input-box">
                <label>Tuition Fee</label>
                <input type="number" value="<?php echo $result['tuition']; ?>" name="tuition" required>
            </div>

            <div class="input-box">
                <label>Lab Fee</label>
                <input type="number" value="<?php echo $result['lab']; ?>" name="lab" required>
            </div>

            <button class="form" type="submit" name="update">Submit</button>
        </form>
    </section>
</body>
</html>

<?php
if (isset($_POST['update'])) {
    $course_name = $_POST['course_name'];
    $description = $_POST['description'];
    $registration = $_POST['registration'];
    $tuition = $_POST['tuition'];
    $lab = $_POST['lab'];

    // Update query for the courses table
    $sql_update_courses = "UPDATE courses SET 
                           course_name='$course_name', 
                           description='$description' 
                           WHERE course_id='$id'";

    // Update query for the fees table
    $sql_update_fees = "UPDATE fees SET 
                        registration='$registration', 
                        tuition='$tuition', 
                        lab='$lab' 
                        WHERE course_id='$id'";

    $data_courses = mysqli_query($conn, $sql_update_courses);
    $data_fees = mysqli_query($conn, $sql_update_fees);

    if ($data_courses && $data_fees) {
        echo "<script>alert('Record Updated')</script>";
        echo '<meta http-equiv="refresh" content="0; url=http://localhost/test/courses/courses.php" />';
    } else {
        echo "Failed to update";
    }
}
} else {
    echo '<script>alert("Login as admin to continue");window.location.href="../login/admin.php";</script>';
}
include("../footer.php");
?>
