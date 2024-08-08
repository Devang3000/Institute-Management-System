<?php
include("../header.php");
include("../connection.php");

error_reporting(E_ALL);

// Check if user session is set
if (!isset($_SESSION["user"])) {
    die("User session not set. Please log in.");
}

$id = $_SESSION["user"]; // here enrollment id is taken from the username

// Validate input
$id = intval($id);

// Fetching user details
$sql_query = "SELECT * FROM enquiry WHERE id = (SELECT enq_id FROM enrollment WHERE enrollment_id = '$id')";
$data = mysqli_query($conn, $sql_query);

if ($data && mysqli_num_rows($data) > 0) {
    $result = mysqli_fetch_assoc($data);
} else {
    die("Record not found or query failed: " . mysqli_error($conn));
}

// Fetching course name
$coursename_query = "SELECT course_name 
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
$data2 = mysqli_query($conn, $coursename_query);

if ($data2 && mysqli_num_rows($data2) > 0) {
    $result2 = mysqli_fetch_assoc($data2);
} else {
    die("Course record not found or query failed: " . mysqli_error($conn));
}

// Retrieve total fees from enrollment table
$total_fees_query = "SELECT total_fees FROM enrollment WHERE enrollment_id = '$id'";
$total_fees_data = mysqli_query($conn, $total_fees_query);

if ($total_fees_data && mysqli_num_rows($total_fees_data) > 0) {
    $fees_result = mysqli_fetch_assoc($total_fees_data);
    $total_fees = $fees_result['total_fees'];
} else {
    die("Total fees record not found or query failed: " . mysqli_error($conn));
}

// Retrieve payment records for the student
$sql_payments = "SELECT payment_amount
                 FROM payments 
                 WHERE enrollment_id = '$id'";
$payment_data = mysqli_query($conn, $sql_payments);

if (!$payment_data) {
    die("Error fetching payment data: " . mysqli_error($conn));
}

// Calculate total paid amount
$total_paid = 0;
while ($row = mysqli_fetch_assoc($payment_data)) {
    $total_paid += $row['payment_amount'];
}

// Calculate remaining unpaid fees
$remaining_fees = $total_fees - $total_paid;

// Fetch profile picture from studentlogin table
$profile_pic_query = "SELECT profile_picture FROM enquiry WHERE id = (select enq_id from enrollment where enrollment_id = '$id')";
$profile_pic_data = mysqli_query($conn, $profile_pic_query);

if ($profile_pic_data && mysqli_num_rows($profile_pic_data) > 0) {
    $profile_pic_result = mysqli_fetch_assoc($profile_pic_data);
    $profile_picture = $profile_pic_result['profile_picture'];
} else {
    $profile_picture = 'default.jpg'; // Fallback to a default image if none found
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Student Profile Page Design Example</title>

    <meta name="author" content="Codeconvey" />
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet"><link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css'>
    
    <style>
body {
    background: lightgray;
    padding: 0;
    margin: 0;
    font-family: 'Lato', sans-serif;
    color: #000;
}

.student-profile .card {
    border-radius: 10px;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s, box-shadow 0.2s;
}

.student-profile .card .card-header .profile_img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    margin: 10px auto;
    border: 10px solid #ccc;
    border-radius: 50%;
}

.profile, .fees {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 45%;
            margin: 10px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }




.student-profile .card h3 {
    font-size: 20px;
    font-weight: 700;
}

.student-profile .card p {
    font-size: 16px;
    color: #000;
}

.student-profile .table th,
.student-profile .table td {
    font-size: 14px;
    padding: 5px 10px;
    color: #000;
}
.button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 15px;
            transition: background-color 0.3s, transform 0.2s;
        }

        .button:hover {
            background-color: #45a049;
            transform: translateY(-2px);
            text-decoration: none;
            color: white;
        }

       

    
    </style>
</head>
<body>

<section>
    <div class="rt-container">
          <div class="col-rt-12">
              <div class="Scriptcontent">
              
<!-- Student Profile -->
<div class="student-profile py-4">
  <div class="container">
    <div class="row">
      <div class="col-lg-4">
        <div class="card shadow-sm">
          <div class="card-header bg-transparent text-center">
            <img class="profile_img" src="../<?php echo htmlspecialchars($profile_picture); ?>" alt="student dp">
            <h3><?php echo htmlspecialchars($result['full_name']); ?></h3>
          </div>
          <div class="card-body">
            <p class="mb-0"><strong class="pr-1">Enroll ID:</strong><?php echo htmlspecialchars($id); ?></p>
            <p class="mb-0"><strong class="pr-1">Course:</strong><?php echo htmlspecialchars($result2['course_name']); ?></p>
            <p class="mb-0"><strong class="pr-1">Mode:</strong> <?php echo htmlspecialchars($result['lect_mode']); ?></p>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card shadow-sm">
          <div class="card-header bg-transparent border-0">
            <h3 class="mb-0"><i class="far fa-clone pr-1"></i>General Information</h3>
          </div>
          <div class="card-body pt-0">
            <table class="table table-bordered">
              <tr>
                <th width="30%">Email</th>
                <td width="2%">:</td>
                <td><?php echo htmlspecialchars($result['email']); ?></td>
              </tr>
              <tr>
                <th width="30%">Mobile number	</th>
                <td width="2%">:</td>
                <td><?php echo htmlspecialchars($result['mob']); ?></td>
              </tr>
              <tr>
                <th width="30%">Address</th>
                <td width="2%">:</td>
                <td><?php echo htmlspecialchars($result['add_line'] . ', ' . $result['add_line2'] . ', ' . $result['city'] . ', ' . $result['region'] . ', ' . $result['country'] . ', ' . $result['postalcode']); ?></td>
              </tr>
             
              
            </table>
            <a href="change_pass_form.php" class="button">Change password</a>
          </div>
        </div>
          <div style="height: 26px"></div>
        <div class="card shadow-sm">
          <div class="card-header bg-transparent border-0">
            <h3 class="mb-0"><i class="far fa-clone pr-1"></i>Fees Details</h3>
          </div>
          <div class="card-body pt-0">
          <table class="table table-bordered">
              <tr>
                <th width="30%">Total Fees</th>
                <td width="2%">:</td>
                <td><?php echo htmlspecialchars($total_fees); ?></td>
              </tr>
              <tr>
                <th width="30%">Total Paid	</th>
                <td width="2%">:</td>
                <td><?php echo htmlspecialchars($total_paid); ?></td>
              </tr>
              <tr>
                <th width="30%">Remaining</th>
                <td width="2%">:</td>
                <td><?php echo htmlspecialchars($remaining_fees); ?></td>
              </tr>
             
              
            </table>
            <a href="../fee_receipts.php?id=<?php echo $id; ?>" class="button">View Fee Receipts</a>
            <a href="../payment_form.php" class="button">Pay Fee</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- partial -->
           
    		</div>
		</div>
    </div>
</section>
     


    <!-- Analytics -->

	</body>
</html>










<!-- **************************************************************************************************-->


<?php
include("../footer.php");
?>
