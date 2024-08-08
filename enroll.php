<?php
include("header.php");
include("connection.php");
error_reporting(E_ALL);

$admin_logged_in = isset($_SESSION["admin_logged_in"]) && $_SESSION["admin_logged_in"]; 
if($admin_logged_in){

$id = intval($_GET['id']);

// Use prepared statements to prevent SQL injection
$sql_query = $conn->prepare("SELECT * FROM enquiry WHERE id = ?");
$sql_query->bind_param("i", $id);
$sql_query->execute();
$data = $sql_query->get_result();

if ($data && $data->num_rows > 0) {
    $result = $data->fetch_assoc();
} else {
    die("Record not found.");
}

$coursename_query = $conn->prepare("SELECT course_name FROM courses WHERE course_id = (SELECT course_id FROM enquiry WHERE id = ?)");
$coursename_query->bind_param("i", $id);
$coursename_query->execute();
$data2 = $coursename_query->get_result();

if ($data2) {
    $result2 = $data2->fetch_assoc();
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
    <title>Registration Form</title>
    <style>
        /* Import Google font - Poppins */
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

        .title {
            font-size: 2.5rem;
            color: #333;
            font-weight: 500;
            text-align: center;
        }

        .container {
            position: relative;
            max-width: 500px;
            width: 100%;
            background: #fff;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            justify-content: center;
            margin: auto;
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

        /*Responsive*/
        @media screen and (max-width: 500px) {
            .form .column {
                flex-wrap: wrap;
            }

            .form :where(.mode-option, .mode) {
                row-gap: 15px;
            }
        }
    </style>
</head>
<body>
    <section class="container">
        <form class="form" method="POST" enctype="multipart/form-data">
            <div class="title">Enrollment details</div>
            <div class="input-box">
                <label>Enquiry Id</label>
                <input type="text" value="<?php echo $result['id']; ?>" name="enq_id" required readonly>
            </div>
            <div class="input-box">
                <label>Name</label>
                <input type="text" value="<?php echo $result['full_name']; ?>" name="full_name" required readonly>
            </div>
            <div class="input-box">
                <label>Course</label>
                <input type="hidden" value="<?php echo $result['course_id'];?>" name="course_id" readonly required>
                <input type="text" value="<?php echo $result2['course_name'];?>" name="course_name" readonly required>
            </div>
            <div class="input-box">
                <label>Mobile number</label>
                <input type="text" value="<?php echo $result['mob']; ?>" name="mob" required readonly>
            </div>
            <div class="input-box">
                <label>Email</label>
                <input type="text" value="<?php echo $result['email']; ?>" name="email" required readonly>
            </div>
            <div class="input-box">
                <label>Profile Picture</label>
                <input type="file" name="profile_picture" id="profile_picture" accept="image/*" required onchange="previewImage(event)">
                <img id="image_preview" src="<?php echo htmlspecialchars($result['profile_picture']); ?>" height="200" width="300" />
            </div>
            <button class="form" type="submit" name="update">Submit</button>
        </form>
    </section>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('image_preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>

<?php
if (isset($_POST['update'])) {
    $id = $_POST['enq_id'];
    $course_id = $_POST['course_id'];

    // Profile picture handling
    $profile_picture = $_FILES['profile_picture'];
    $target_dir = "images/";
    $target_file = $target_dir . basename($profile_picture["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_file_types = array("jpg", "jpeg", "png", "gif");

    // Check if image file is an actual image or fake image
    $check = getimagesize($profile_picture["tmp_name"]);
    if ($check !== false && in_array($imageFileType, $allowed_file_types)) {
        if (move_uploaded_file($profile_picture["tmp_name"], $target_file)) {
            // Profile picture uploaded successfully
            // Check if the person is already enrolled in this course
            $check_query = $conn->prepare("SELECT * FROM enrollment WHERE enq_id = ?");
            $check_query->bind_param("i", $id);
            $check_query->execute();
            $check_result = $check_query->get_result();

            if ($check_result->num_rows > 0) {
                echo "<script>alert('This person is already enrolled in this course.')</script>";
            } else {
                $insert_query = $conn->prepare("INSERT INTO enrollment (enq_id, total_fees, unpaid) SELECT ?, registration + tuition + lab, registration + tuition + lab FROM fees WHERE course_id = ?");
                $insert_query->bind_param("ii", $id, $course_id);

                if ($insert_query->execute()) {
                    // Insert enrollment ID into studentlogin table
                    $enrollment_id = $conn->insert_id;
                    $enrollment_data_query = $conn->prepare("SELECT * FROM enquiry WHERE id = ?");
                    $enrollment_data_query->bind_param("i", $id);
                    $enrollment_data_query->execute();
                    $enrollment_data = $enrollment_data_query->get_result()->fetch_assoc();
                    $password = str_replace(' ', '', $enrollment_data['full_name']) . substr($enrollment_data['mob'], -4);

                    $insert_login_query = $conn->prepare("INSERT INTO studentlogin (enrollment_id, password) VALUES (?, ?)");
                    $insert_login_query->bind_param("is", $enrollment_id, $password);
                    $insert_login_query->execute();

                    $insert_picture_query = $conn->prepare("UPDATE enquiry SET profile_picture = ? WHERE id = ?");
                    $insert_picture_query->bind_param("si", $target_file, $id);
                    $insert_picture_query->execute();
                    
                    echo "<script>alert('Record Updated')</script>";
                    echo '<meta http-equiv="refresh" content="0; url=display.php" />';
                } else {
                    echo "Error: " . $insert_query . "<br>" . $conn->error;
                }
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "File is not an image or not allowed file type.";
    }
}
}
else{
    echo '<script>"Login as admin to access this file."</script>';
    echo '<script>window.location.href="http://localhost/test/home.php";</script>';
}


include("footer.php");
?>
