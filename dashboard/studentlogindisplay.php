<?php
include('../connection.php');
include('../header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Payment Display</title>
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

        .student-link {
   
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
                <li><a href="admin_dashboard.php">Dashboard Overview</a></li>
                <li><a href="../courses/courses.php">Courses</a></li>
                
                <li><a href="../enrolledstudents.php">Enrollments</a></li>
                <li><a href="../display.php">Enquiries</a></li>
                <li><a href="paymentsdisplay.php" >Payments</a></li>
                <li><a href="adminlogin.php">Admin Accounts</a></li>
                <li><a href="studentlogindisplay.php" class = 'student-link'>Student Logins</a></li>
            </ul>
        </div>

        <div class = 'content'>


        <h3>Student Logins</h3>
            <section id="student_logins">
                
                <h2>Student Logins</h2>
                <!-- Student Logins data will be loaded here by AJAX -->
            </section><br>
                        </div>

</div>
<?php include("../footer.php");?>
    
</body>
</html>