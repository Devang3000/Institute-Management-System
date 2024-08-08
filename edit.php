<?php
include("header.php");
include("connection.php");
error_reporting(E_ALL);

$admin_logged_in = isset($_SESSION["admin_logged_in"]) && $_SESSION["admin_logged_in"];

if ($admin_logged_in) {

$id = $_GET['id'];

// Validate input
$id = intval($id);

$sql_query = "SELECT * FROM enquiry WHERE id = '$id'";
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
    <title>Update Enquiry Details</title>
    <style>
        /* Import Google font - Poppins */
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

        .container {
            position: relative;
            max-width: 700px;
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
        /*Responsive*/
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
            font-weight: bold; /* Make the text bold */
            text-align: center; /* Center the text */
            display: block;
            margin-bottom: 50px; /* Add space below the header */
        }
    </style>
</head>
<body>
    <section class="container">
        <form class="form" method="POST" enctype="multipart/form-data">
            <div class="headerf">Update details</div> 
            <div class="select-box">
                <select name="course_id" required>
                    <option hidden value="">Select Course</option>
                    <?php
                        $course_query = mysqli_query($conn, "SELECT * FROM courses");
                        while ($list = mysqli_fetch_array($course_query)) {
                            $selected = $list['course_id'] == $result['course_id'] ? 'selected' : '';
                            echo "<option value='{$list['course_id']}' $selected>{$list['course_name']}</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="input-box">
                <label>Full Name</label>
                <input type="text" value="<?php echo $result['full_name']; ?>" name="full_name" required>
            </div>
            <div class="input-box">
                <label>Email</label>
                <input type="email" value="<?php echo $result['email']; ?>" name="email" required>
            </div>
            <div class="column">
                <div class="input-box">
                    <label>Mobile</label>
                    <input type="number" value="<?php echo $result['mob']; ?>" name="mob" required>
                </div>
                <div class="input-box">
                    <label>Demo Date</label>
                    <input type="date" value="<?php echo $result['demo_date']; ?>" name="demo_date" required>
                </div>
            </div>
            <div class="mode-box">
                <label>Lecture Mode</label>
                <input type="text" value="<?php echo $result['lect_mode']; ?>" name="lect_mode" required>
            </div>
            <div class="input-box address">
                <label>Address</label>
                <input type="text" value="<?php echo $result['add_line']; ?>" name="add_line" required>
                <input type="text" value="<?php echo $result['add_line2']; ?>" name="add_line2" required>
            </div>
            <br>
            <label>Country</label>
            <div class="select-box">
                <select name="country" required>
                    <option hidden value=""><?php echo $result['country']; ?></option>
                    <option value="America" <?php echo ($result['country'] == 'America') ? 'selected' : ''; ?>>America</option>
                    <option value="Japan" <?php echo ($result['country'] == 'Japan') ? 'selected' : ''; ?>>Japan</option>
                    <option value="India" <?php echo ($result['country'] == 'India') ? 'selected' : ''; ?>>India</option>
                    <option value="Nepal" <?php echo ($result['country'] == 'Nepal') ? 'selected' : ''; ?>>Nepal</option>
                </select>
            </div> 
            <div class="input-box">
                <label>City</label>
                <input type="text" value="<?php echo $result['city']; ?>" name="city" required>
            </div>
            <div class="column">
                <div class="input-box">
                    <label>Region</label>
                    <input type="text" value="<?php echo $result['region']; ?>" name="region" required>
                </div>
                <div class="input-box">
                    <label>Postal Code</label>
                    <input type="text" value="<?php echo $result['postalcode']; ?>" name="postalcode" required>
                </div>
            </div>
            <div class="input-box">
                <label>Profile Picture</label>
                <input type="file" name="profile_picture" id="profile_picture" accept="image/*" onchange="previewImage(event)">
                <img id="image_preview" src="<?php echo htmlspecialchars($result['profile_picture']); ?>" height="200" width="300" />
                <input type="hidden" name="current_profile_picture" value="<?php echo htmlspecialchars($result['profile_picture']); ?>">
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
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>

<?php
if (isset($_POST['update'])) {
    $course_id = $_POST['course_id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $mob = $_POST['mob'];
    $demo_date = $_POST['demo_date'];
    $lect_mode = $_POST['lect_mode'];
    $add_line = $_POST['add_line'];
    $add_line2 = $_POST['add_line2'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $region = $_POST['region'];
    $postalcode = $_POST['postalcode'];
    
    $profile_picture = $_FILES['profile_picture']['name'];
    $target_dir = "images/";
    $target_file = $target_dir .basename($profile_picture);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $current_profile_picture = $_POST['current_profile_picture'];
    
    if ($profile_picture) {
        $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
        if ($check !== false) {
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
            } else {
                if ($_FILES["profile_picture"]["size"] > 500000) {
                    echo "Sorry, your file is too large.";
                } else {
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif" ) {
                        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    } else {
                        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                            $profile_picture = $target_file;
                        } else {
                            echo "Sorry, there was an error uploading your file.";
                            $profile_picture = $current_profile_picture;
                        }
                    }
                }
            }
        } else {
            echo "File is not an image.";
            $profile_picture = $current_profile_picture;
        }
    } else {
        $profile_picture = $current_profile_picture;
    }

    $sql_query = "UPDATE enquiry SET 
                    course_id='$course_id', 
                    full_name='$full_name', 
                    email='$email', 
                    mob='$mob', 
                    demo_date='$demo_date', 
                    lect_mode='$lect_mode', 
                    add_line='$add_line', 
                    add_line2='$add_line2', 
                    country='$country',
                    city='$city',
                    region='$region',
                    postalcode='$postalcode',
                    profile_picture='images/$profile_picture'
                  WHERE id='$id'";

    $data = mysqli_query($conn, $sql_query);
    if ($data) {
        echo "<script>alert('Record Updated')</script>";
        echo '<meta http-equiv="refresh" content="0; url=display.php" />';
    } else {
        echo "Failed to update";
    }
}
} else {
    echo '<script>alert("Login as admin to continue");window.location.href="login/admin.php";</script>';
}
include("footer.php");
?>
