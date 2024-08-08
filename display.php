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
   
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <!-- Including scripting file. -->
    <script type="text/javascript" src="enquiry.js"></script>

    <style>
        .wrapper { 
            display: flex;
           
         }
        .myapp-sidebar { width: 250px;
                        background-color: #2c3e50; 
                        color: white; padding:35px;
                        height: 100vh;
                        align-self: flex-start;
                        z-index: 600;
                        position: sticky;
                        top: 0; 
                        left:0;
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
        table, th, td { 
            border: 1px solid grey;
             overflow-x: scroll; 
            }
        table thead th, table tfoot th { 
            color: #777; 
            background: rgba(0, 0, 0, .1);
         }

        table th, table td { 
            padding: .5em;
             text-align: left; 
            }
        [data-table-theme*=zebra] tbody tr:nth-of-type(odd) { background: rgba(0, 0, 0, .05); }
        .center { text-align: center; }
        .update { color: green; }
        .delete { color: red; }
        .btn { padding: 10px 15px;
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
        .btn-info { background-color: #17a2b8;
             color: white;
             }
        .btn-info:hover { 
            background-color: #138496; 
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

        .search-container {
            display: flex;
            justify-content: left;
            margin-bottom: 20px;
        }
        .searchTerm {
            width: 300px;
            border: 2px solid #ccc;
            padding: 10px;
            border-radius: 5px ;
            outline: none;
        }
        .searchTerm:focus {
            border-color: #6c757d;
        }
        h1{
            justify-content: center;
            text-align: center;
        }
        .display {
                font-weight: bold;
                background-color: lightgreen; /* Optional background color */
                padding: 5px;
                border-radius: 3px;
                text-decoration: none; /* Remove underline */
                }
                #loading {
            position: fixed;
            width: 100%;
            height: 100%;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            z-index: 9999; /* Ensure it's on top of other content */
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
   <script>
        // JavaScript to hide the loading screen after 2 seconds
        window.addEventListener('load', function() {
            setTimeout(function() {
                document.getElementById('loading').style.display = 'none';
            }, 1000);
        });
    </script>
</head>
<body>
<div id="loading">Loading, please wait...</div>

<div id="content">

    <div class="wrapper">
        <div class="myapp-sidebar">
            <h2>Admin Dashboard</h2>
            <ul>
                <li><a href="http://localhost/test/dashboard/admin_dashboard.php">Dashboard Overview</a></li>
                <li><a href="courses/courses.php">Courses</a></li>
                <li><a href="enrolledstudents.php">Enrollments</a></li>
                <li><a href="display.php"class = 'display'>Enquiries</a></li>
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
             <h1>ENQUIRIES</h1>
            <div class="search-container">
                <input type="text" class="searchTerm" id="search" placeholder="Search" autofocus />
                
            </div>
            
           
            <div id="display"></div>

            <script>
                var inputBox = document.getElementById("search");
                if (inputBox) {
                    inputBox.addEventListener('focus', function() {
                        runPhpCode();
                    });
                }

                function runPhpCode() {
                    // Perform an AJAX request
                    var xhr = new XMLHttpRequest();
                    xhr.open("GET", "search/process.php", true);
                    xhr.onload = function () {
                        if (xhr.status == 200) {
                            // Update the display area with the response
                            document.getElementById("display").innerHTML = xhr.responseText;
                        }
                    };
                    xhr.send();
                }
            </script>

           

            <script>
                function checkdelete() {
                    return confirm('Are you sure you want to delete this record?');
                }
            </script>
           


            <?php 
            } else {
                echo '<script>alert("Login as admin to continue")</script>';
                echo '<script>window.location.href="http://alphainstitute.infinityfreeapp.com";</script>';
                exit;
            }
            ?>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    </div>
</body>

</html>