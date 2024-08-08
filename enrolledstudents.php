<?php
include "connection.php";
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Display data</title>
    <style>
        .wrapper {
            display: flex;
            align-items: flex-start;
        }

        .myapp-sidebar {
            
            width: 250px;
            background-color: #2c3e50;
            color: white;
            padding: 35px;
            height: 100vh;
            align-self: auto;
            z-index: 600;
            position: sticky    ;
            top: 0;
            overflow-y: scroll;
        }

        .myapp-sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .myapp-sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .myapp-sidebar ul li {
            margin: 15px 0;
        }

        .myapp-sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .myapp-sidebar ul li a:hover {
            background-color: #34495e;
        }

        .main-content {
            flex: 1;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 20px;
            overflow-x: scroll;
        }


        table, td {
            border: 1px solid grey;
            overflow-x: auto;
        }

        table, th {
            border: 1px solid grey;
            
            
        }

        table thead th, table tfoot th {
            color: #777;
            background: rgba(0, 0, 0, .1);
        }

        table th, table td {
            padding: .5em;
            text-align: center;
        }

        [data-table-theme*=zebra] tbody tr:nth-of-type(odd) {
            background: rgba(0, 0, 0, .05);
        }

        .center {
            text-align: center;
        }

        .update {
            color: green;
        }

        .delete {
            color: red;
        }

        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            margin-right: 5px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-info {
            background-color: #17a2b8;
            color: white;
        }

        .btn-info:hover {
            background-color: #138496;
        }

        form {
            margin-left: 20px;
        }

        .form-control {
            padding: 10px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-right: 5px;
            width: 300px;
        }

        .form-inline {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin: 20px 0;
        }

        .btn-payment {
            background-color: #ffc107;
            color: black;
            padding:10px;
            margin: 10px;
        }

        .btn-payment:hover {
            background-color: #e0a800;
        }

        #amount {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    .enrolled {
   
         font-weight: bold;
         background-color: lightgreen; /* Optional background color */
         padding: 5px;
         border-radius: 3px;
         text-decoration: none; /* Remove underline */
                }

        @media (max-width: 768px) {
            .myapp-sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .myapp-sidebar ul {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .main-content {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
    <div class="myapp-sidebar">
            <h2>Admin Dashboard</h2>
            <ul>
                <li><a href="http://localhost/test/dashboard/admin_dashboard.php">Dashboard Overview</a></li>
                <li><a href="courses/courses.php">Courses</a></li>
                <li><a href="enrolledstudents.php"class = 'enrolled'>Enrollments</a></li>
                <li><a href="display.php">Enquiries</a></li>
                <li><a href="http://localhost/test/dashboard/paymentsdisplay.php">Payments</a></li>
                <li><a href="http://localhost/test/dashboard/adminlogin.php">Admin Accounts</a></li>
                <li><a href="http://localhost/test/dashboard/studentlogindisplay.php">Student Logins</a></li>
            </ul>
        </div>

        <div class="main-content">
            <?php 
            $admin_logged_in = isset($_SESSION["admin_logged_in"]) && $_SESSION["admin_logged_in"]; 
            if ($admin_logged_in){
            ?>

            <!-- Search and Filter Options -->
            <form id="search-filter-form" method="POST" action="">
                <div class="form-inline">
                    <input type="search" class="form-control" id="search-keyword" name="keyword" placeholder="Search here..." />
                    <button type="button" class="btn btn-success" id="search-button">Search</button>
                    
                </div>

                <div class="form-inline">
                    <select class="form-control" name="course" id = 'course'>
                        <option value="">Filter by Course</option>
                        <?php
                            $sql = "SELECT DISTINCT(course_name) FROM courses";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='".$row['course_name']."'>".$row['course_name']."</option>";
                            }
                        ?>
                    </select>

                    <select class="form-control" name="mode" id = 'mode'>
                        <option value="">Filter by Lecture Mode</option>
                        <option value="Online">Online</option>
                        <option value="Offline">Offline</option>
                    </select>

                    <input type="number" class="form-control" name="unpaid" id = 'unpaid' placeholder="unpaid Fees">
                    
                    <button type="button" class="btn btn-success" id="filter-button">Filter</button>
                    <button type="button" class="btn btn-info" id="clear-filters-button">Clear Filters</button>
                </div>
            </form>

            <!-- Table to Display Results -->

          
            <table id="results-table" data-table-theme="default zebra">

            <colgroup>
        <col span="1" style="width: 5%;"> <!--enq id-->
        <col span="1" style="width: 5%;"> <!--Enroll id -->
        <col span="4" style="width: 12%; "> <!--course naeme -->
        <col span="3" > <!--mob no -->
        <col span="1" style="width: 11%;"> 
        <col span="2" style="width: 6%;"> <!--edit dlt -->
        
       
    </colgroup>


                <thead>
                    <tr>
                        <th>ENQ ID</th>
                        <th>ENROLL ID</th>
                        <th>COURSE NAME</th>
                        <th>FULL NAME</th>
                        <th>EMAIL</th>
                        <th>MOBILE NUMBER</th>
                        <th>MODE</th>
                        <th>TOTAL FEES</th>
                        <th>UNPAID</th>
                        <th>PAYMENT</th>
                        <th>EDIT</th>
                        <th>DELETE</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Results will be populated here -->
                </tbody>
            </table><br><br>

            <script>
                document.getElementById('search-keyword').addEventListener('input', function() {
                    fetchResults();
                });

                document.getElementById('search-button').addEventListener('click', function() {
                    fetchResults();
                });

               document.getElementById('course').addEventListener('input', function() {
                   fetchResults();
               });

               document.getElementById('mode').addEventListener('input', function() {
                   fetchResults();
               });

               document.getElementById('unpaid').addEventListener('input', function() {
                   fetchResults();
               });

                document.getElementById('filter-button').addEventListener('click', function() {
                    fetchResults();
                });

                document.getElementById('clear-filters-button').addEventListener('click', function() {
                    document.getElementById('search-filter-form').reset();
                    fetchResults();
                });

              //  document.getElementById('reload-button').addEventListener('click', function() {
               //     fetchResults();
               // });

                function fetchResults() {
                    const form = document.getElementById('search-filter-form');
                    const formData = new FormData(form);

                    fetch('search/enrolledfetch_results.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        const tbody = document.querySelector('#results-table tbody');
                        tbody.innerHTML = '';
                        data.forEach(row => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>${row.id}</td>
                                <td>${row.enrollment_id}</td>
                                <td>${row.course_name}</td>
                                <td>${row.full_name}</td>
                                <td>${row.email}</td>
                                <td>${row.mob}</td>
                                <td>${row.lect_mode}</td>
                                <td>${row.total_fees}</td>
                                <td>${row.unpaid}</td>
                                <td class='center'>
                                    <form method='POST' action='update_payment.php' style='display:inline-block;'>
                                        <input type='hidden' name='enrollment_id' value='${row.enrollment_id}'>
                                        <input type='number' id = 'amount' name='payment' min='0' max='${row.unpaid}' placeholder='Amount' required>
                                            
                                        <button type='submit' class='btn btn-payment'>Receive</button>
                                    </form>
                                </td>
                                <td class='center'>
                                    <a href='edit.php?id=${row.id}'>
                                        <button type='button' class='update'><i class='fas fa-edit'></i></button>
                                    </a>
                                </td>
                                <td class='center'>
                                    <a href='enrolledDelete.php?id=${row.id}'>
                                        <button type='submit' class='delete' onclick='return checkdelete()'><i class='fas fa-trash-alt'></i></button>
                                    </a>
                                </td>
                            `;
                            tbody.appendChild(tr);
                        });
                    })
                    .catch(error => console.error('Error:', error));
                }

                function checkdelete() {
                    return confirm('Are you sure you want to delete this record?');
                }

                // Fetch results on page load
                document.addEventListener('DOMContentLoaded', fetchResults);
            </script>

            <?php 
            } else {
                echo '<script>alert("Login as admin to continue")</script>';
                echo '<script>window.location.href="http://localhost/test/home.php";</script>';
            }
            ?>
            
        </div>
        
    </div>
    <?php include('footer.php') ?>
</body>
</html>
