<?php
include('../connection.php');
include('../header.php');

// Constants for pagination
$recordsPerPage = 10; // Number of records per page

// Determine current page for payments
$currentPaymentPage = isset($_GET['payment_page']) ? (int)$_GET['payment_page'] : 1;
$startPaymentRecord = ($currentPaymentPage - 1) * $recordsPerPage;

// Determine current page for student logins
$currentStudentPage = isset($_GET['student_page']) ? (int)$_GET['student_page'] : 1;
$startStudentRecord = ($currentStudentPage - 1) * $recordsPerPage;

// Fetching course names and enrollment counts
$coursesData = $conn->query("
    SELECT courses.course_name, COUNT(enrollment.enrollment_id) AS enrollment_count 
    FROM courses 
    LEFT JOIN enquiry ON courses.course_id = enquiry.course_id 
    LEFT JOIN enrollment ON enquiry.id = enrollment.enq_id 
    GROUP BY courses.course_name
");

$courseNames = [];
$enrollmentCounts = [];
while ($row = $coursesData->fetch_assoc()) {
    $courseNames[] = $row['course_name'];
    $enrollmentCounts[] = $row['enrollment_count'];
}

$courseNamesJson = json_encode($courseNames);
$enrollmentCountsJson = json_encode($enrollmentCounts);

// Fetch summary statistics
$courseCount = $conn->query("SELECT COUNT(*) as count FROM courses")->fetch_assoc()['count'];
$enrollmentCount = $conn->query("SELECT COUNT(*) as count FROM enrollment")->fetch_assoc()['count'];
//$enquiryCount = $conn->query("SELECT COUNT(*) as count FROM enquiry")->fetch_assoc()['count'];

$enquiryCount = $conn->query("
    SELECT COUNT(*) as count 
    FROM enquiry e 
    LEFT JOIN enrollment en ON e.id = en.enq_id 
    WHERE en.enq_id IS NULL
")->fetch_assoc()['count'];

$paymentSum = $conn->query("SELECT SUM(payment_amount) as total FROM payments")->fetch_assoc()['total'];
$unpaidPayments = $conn->query("
    SELECT SUM(fees.tuition + fees.registration + fees.lab) AS total_unpaid 
    FROM enrollment 
    JOIN enquiry ON enrollment.enq_id = enquiry.id 
    JOIN fees ON enquiry.course_id = fees.course_id 
    LEFT JOIN payments ON enrollment.enrollment_id = payments.enrollment_id 
    WHERE payments.payment_id IS NULL
")->fetch_assoc()['total_unpaid'];

$monthlyPaymentsData = $conn->query("
    SELECT DATE_FORMAT(payment_date, '%Y-%m') AS month, SUM(payment_amount) AS total 
    FROM payments 
    GROUP BY DATE_FORMAT(payment_date, '%Y-%m')
");

$monthlyPayments = [];
while ($row = $monthlyPaymentsData->fetch_assoc()) {
    $monthlyPayments[$row['month']] = $row['total'];
}

$months = json_encode(array_keys($monthlyPayments));
$monthlyPaymentTotals = json_encode(array_values($monthlyPayments));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        
        h2 {
            word-wrap: break-word;
        }
        .parent {
            padding: 20px;
            margin: 0px;
        }
        .child {
            display: inline-block;
            border: 1px solid black;
            padding: 10px;
            margin-left: 0px;
            align-content: center;
            margin: 10px;
            margin-right: 40px;
            margin-left: 30px;
        }

        h3{
            
            text-align: center;
            font-size: 1.5em;
            padding: 5px;
            margin: 5px;

        }
        .dashboard {
   
   font-weight: bold;
   background-color: lightgreen; /* Optional background color */
   padding: 5px;
   border-radius: 3px;
   text-decoration: none; /* Remove underline */
          }
        
        
        
    </style>
     <script>
        $(document).ready(function() {
            loadSection('payments', 1);
            loadSection('student_logins', 1);

            $(document).on('click', '.pagination-link', function(e) {
                e.preventDefault();
                var section = $(this).data('section');
                var page = $(this).data('page');
                loadSection(section, page);
            });
        });

        function loadSection(section, page) {
            $.ajax({
                url: 'fetch_data.php',
                type: 'GET',
                data: { section: section, page: page },
                success: function(response) {
                    $('#' + section).html(response);
                }
            });
        }
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="sidebar">
            <br>
            <h2>Admin <br> Dashboard</h2>
            <ul>
                <li><a href="admin_dashboard.php" class = 'dashboard'>Dashboard Overview</a></li>
                <li><a href="../courses/courses.php">Courses</a></li>
                
                <li><a href="../enrolledstudents.php">Enrollments</a></li>
                <li><a href="../display.php">Enquiries</a></li>
                <li><a href="paymentsdisplay.php">Payments</a></li>
                <li><a href="adminlogin.php">Admin Accounts</a></li>
                <li><a href="studentlogindisplay.php">Student Logins</a></li>
            </ul>
        </div>
        <div class="content">
            <section id="overview">
                <h3>Dashboard Overview</h3>
                <div class='summary'>
                    <div class='summary-item'><h3>Total Courses</h3><p><?php echo $courseCount; ?></p></div>
                    <div class='summary-item'><h3>Total Enrollments</h3><p><?php echo $enrollmentCount; ?></p></div>
                    <div class='summary-item'><h3>Total Enquiries</h3><p><?php echo $enquiryCount; ?></p></div>
                    <div class='summary-item'><h3>Total Payments Received</h3><p>&#8377;<?php echo $paymentSum; ?></p></div>
                    <div class='summary-item'><h3>Total Unpaid Payments</h3><p>&#8377;<?php echo $unpaidPayments; ?></p></div>
                </div>
                <br>
                <div class="parent">
                    <div class='child' style="height:55vh; width:33vw" ><canvas id="overviewChart"></canvas></div>
                    <div class='child' style="height:55vh; width:33vw"><canvas id="courseWiseEnrollmentsChart"></canvas></div>
                    <div class='child' style="height:55vh; width:33vw"><canvas id="enquiryVsEnrollmentsChart"></canvas></div>
                    <div class='child' style="height:55vh; width:33vw"><canvas id="monthlyPaymentsChart"></canvas></div>
                </div>
                <br>
                <!-- Additional sections can be added below -->
            </section>

            
            

            

            
           
        </div>
    </div>
    <script>
    // Summary chart
    const overviewChartCtx = document.getElementById('overviewChart').getContext('2d');
    new Chart(overviewChartCtx, {
        type: 'bar',
        data: {
            labels: ['Courses', 'Enrollments', 'Enquiries'],
            datasets: [{
                label: 'Overview',
                data: [<?php echo $courseCount; ?>, <?php echo $enrollmentCount; ?>, <?php echo $enquiryCount; ?>],
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
                borderColor: ['#FF6384', '#36A2EB', '#FFCE56'],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Enquiry vs Enrollments chart
    const enquiryVsEnrollmentsChartCtx = document.getElementById('enquiryVsEnrollmentsChart').getContext('2d');
    new Chart(enquiryVsEnrollmentsChartCtx, {
        type: 'pie',
        data: {
            labels: ['Enquiries', 'Enrollments'],
            datasets: [{
                backgroundColor: ['#b91d47', '#00aba9'],
                data: [<?php echo $enquiryCount; ?>, <?php echo $enrollmentCount; ?>]
            }]
        },
        options: {
            title: {
                display: true,
                text: 'Enquiries vs Enrollments'
            }
        }
    });

    // Course wise Enrollments chart
    const courseNames = <?php echo $courseNamesJson; ?>;
    const enrollmentCounts = <?php echo $enrollmentCountsJson; ?>;
    const courseWiseEnrollmentsChartCtx = document.getElementById('courseWiseEnrollmentsChart').getContext('2d');
    new Chart(courseWiseEnrollmentsChartCtx, {
        type: 'bar',
        data: {
            labels: courseNames,
            datasets: [{
                backgroundColor: ['#b91d47', '#00aba9', '#2a9d8f', '#e9c46a', '#f4a261', '#e76f51'],
                data: enrollmentCounts
            }]
        },
        options: {
            title: {
                display: false,
                text: 'Course wise Enrollments'
            }
        }
    });

    // Monthly Payments chart
    const months = <?php echo $months; ?>;
    const monthlyPaymentTotals = <?php echo $monthlyPaymentTotals; ?>;
    const monthlyPaymentsChartCtx = document.getElementById('monthlyPaymentsChart').getContext('2d');
    new Chart(monthlyPaymentsChartCtx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Monthly Payments',
                data: monthlyPaymentTotals,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>
</body>
</html> 
<?php include('../footer.php'); ?>
