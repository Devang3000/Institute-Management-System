<?php
include("header.php");
include("connection.php");
error_reporting(E_ALL);

$id = $_SESSION["user"]; //here enrollment id is taken from the username

// Validate input
$id = intval($id);

$sql_query = "SELECT * FROM enquiry WHERE id = (select enq_id from enrollment where enrollment_id = '$id')";
$data = mysqli_query($conn, $sql_query);

if ($data && mysqli_num_rows($data) > 0) {
    $result = mysqli_fetch_assoc($data);
} else {
    die("Record not found.");
}



$coursename = "SELECT course_name 
FROM courses 
WHERE course_id = (
    SELECT course_id 
    FROM enquiry 
    WHERE id = (
        SELECT enq_id 
        FROM enrollment 
        WHERE enrollment_id = $id
    )
)";

$data2 = mysqli_query($conn, $coursename);

if ($data2) {
    $result2 = mysqli_fetch_assoc($data2);
} else {
    die("Record not found.");
}

// Retrieve payment records for the student
$sql_payments = "SELECT p.*, e.total_fees
                 FROM payments p 
                 INNER JOIN enrollment e ON p.enrollment_id = e.enrollment_id
                 WHERE p.enrollment_id = '$id'";
$payment_data = mysqli_query($conn, $sql_payments);
$result3 = mysqli_fetch_assoc($payment_data);

// Calculate total paid amount
$total_paid = 0;
while ($row = mysqli_fetch_assoc($payment_data)) {
    $total_paid += $row['payment_amount'];
}

// Calculate remaining unpaid fees
$total_fees = $result3['total_fees'];
$remaining_fees = $total_fees - $total_paid;
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

    .wrapper{
        border: 10 px solid blue;
    }

    .button {
    display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    outline: none;
    color: #fff;
    background-color: #4CAF50;
    border: none;
    border-radius: 15px;
    box-shadow: 0 9px #999;
}

.button:hover {background-color: #3e8e41}

.button:active {
    background-color: #3e8e41;
    box-shadow: 0 5px #666;
    transform: translateY(4px);
}

    
    
    </style>
</head>



           

<div id="wrapper">

<div class = "float:left">
    <section class="container">

        <form class="form" method="POST">
        <div class="headerf">Your details</div> 

        <div class="input-box">
                <label>Course</label>
                <input type="hidden" value="<?php echo $result['course_id'];?>" name="course_id" readonly required>
                <input type="text" value="<?php echo $result2['course_name'];?>" name="course_name" readonly required>
            </div>  

            <div class="input-box">
                <label>Full Name</label>
                <input type="text" value="<?php echo $result['full_name']; ?>" name="full_name" required readonly>
            </div>

            <div class="input-box">
                <label>Email</label>
                <input type="email" value="<?php echo $result['email']; ?>" name="email" required readonly>
            </div>

            <div class="column">
                <div class="input-box">
                    <label>Mobile</label>
                    <input type="number" value="<?php echo $result['mob']; ?>" name="mob" required readonly>
                </div>
            </div>

            <div class="mode-box">
                <label>Lecture Mode</label>
                <input type="text" value="<?php echo $result['lect_mode']; ?>" name="lect_mode" required readonly>
            </div>

            <div class="input-box address">
                <label>Address</label>
                <input type="text" value="<?php echo $result['add_line']; ?>" name="add_line" required readonly>
                <input type="text" value="<?php echo $result['add_line2']; ?>" name="add_line2" required readonly>
            </div>

            
                
            
                <div class="input-box">
                    
                <label>Country</label>
                    <input type="text" value="<?php echo $result['country']; ?>" name="country" required readonly>
                        
                    
                
                </div>
                <div class="input-box">
                    <label>City</label>
                    <input type="text" value="<?php echo $result['city']; ?>" name="city" required readonly>
                </div>
            

            <div class="column">
                <div class="input-box">
                    <label>Region</label>
                    <input type="text" value="<?php echo $result['region']; ?>" name="region" required readonly>
                </div>
                <div class="input-box">
                    <label>Postal Code</label>
                    <input type="text" value="<?php echo $result['postalcode']; ?>" name="postalcode" required readonly>
                </div>
            </div>
           <!-- <button class="form" type="submit" name="update">Submit</button>-->
        </form>
    </section>
</div>
<div class = "float:right">
<section class = 'container'>
    

<form class="form" method="POST">

<!-- Button to view fee receipts and remaining fees -->
<div class="headerf">Your Fee Information</div>

    
        <div>
        <p>Total Fees: <?php echo $total_fees; ?></p>
        <p>Total Paid: <?php echo $total_paid; ?></p>
        <p>Remaining Fees: <?php echo $remaining_fees; ?></p>

        <table>
        <tr>
            <td>
            <a href="fee_receipts.php?id=<?php echo $id; ?>" class="button">View Fee Receipts</a>
        </div>
        </td>
        <td>
        <div >
        <a href="payment_form.php" class="button">Pay Fee</a>
        </td>    
    </tr>
    </div>
    
</table>

</form>





    </section>
</div>
</div>
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
                    postalcode='$postalcode'
                  WHERE id='$id'";

    $data = mysqli_query($conn, $sql_query);
    if ($data) {
        echo "<script>alert('Record Updated')</script>";
        echo '<meta http-equiv="refresh" content="0; url=http://localhost/test/display.php" />';
    } else {
        echo "Failed to update";
    }
}
include("footer.php");
?>
