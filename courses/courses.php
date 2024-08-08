<?php
include "../connection.php";
include '../header.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Display courses data</title>
    <style>

        

        .wrapper {
            display: flex;
            
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
            table-layout:fixed;
            margin-bottom: 20px;
            
            overflow-x: auto;
        }

        table, th, td {
            border: 1px solid grey;
            overflow-x: auto;
        }

        table thead th, table tfoot th {
            color: #777;
            background: rgba(0, 0, 0, .1);
        }

        table th, table td {
            padding: .5em;
            text-align: left;
            
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

        .btn-add {
            background-color: green;
            color: white;
        }

        .btn-info:hover {
            background-color: #138496;
        }
        .btn-add:hover {
            background-color: lightgreen;
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
            
            justify-content: left;
            align-items: left;
            margin-left: 10px;
            margin-right: 150px;
            padding-right: 200px;
        }
        .form-inline2 {
            align-self: flex-end;
            justify-content:right;
            align-items: right;
            margin-left: 10px;
            margin-right: 10px;
            padding-right: 0px;
            padding-left: px;
        }
        .container{
            margin-left:0px;
            margin-right: 10px;
            justify-content: flex-end;
        }
        .course {
   
   font-weight: bold;
   background-color: lightgreen; /* Optional background color */
   padding: 5px;
   border-radius: 3px;
   text-decoration: none; /* Remove underline */
          }
        


        @media (max-width: 768px) {
            .myapp-sidebar {
                width: auto;
                height: auto;
            
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
                <li><a href="courses.php"class = 'course'>Courses</a></li>
                <li><a href="../enrolledstudents.php">Enrollments</a></li>
                <li><a href="../display.php">Enquiries</a></li>
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
            <form method="POST" action="">
                <div class = 'container'>
                <div class="form-inline">
               
                
               <input type="search" class="form-control" name="keyword" value="<?php echo isset($_POST['keyword']) ? $_POST['keyword'] : '' ?>" placeholder="Search here..." required=""/>
               <button class="btn btn-success" name="search">Search</button>
               <a href="courses.php" class="btn btn-info">Reload</a>
               
           </div>
           <div class="form-inline2">
               <a href="add.php" class="btn btn-add">Add Course</a>
               
           </div>

           
                </div>

               
                
            </form>

            

            <?php
            //if (isset($_POST['search'])) {
              //  include 'search/search.php';
            //} else {
                $sql = "SELECT c.course_id, c.course_name, c.description, f.registration, f.tuition, f.lab, SUM(f.registration + f.tuition + f.lab) AS total_fees
                        FROM 
                        courses c
                        JOIN 
                        fees f ON f.course_id = c.course_id
                        GROUP BY c.course_id;";
                                    
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
            ?>

            <table data-table-theme="default zebra">
                <colgroup>
                    <col span="1" style="width: 3%;"><!--course id-->
                    <col span="1" style="width: 10%;"><!--course name-->
                    <col span="1" style="width: 20%;"><!--course description-->
                    <col span="6" style="width: 4%;">
                    
                </colgroup>
                <tr>
                    <th>course ID</th>
                    <th>Course Name</th>
                    <th>course description</th>
                    <th>registration </th>
                    <th>tution</th>
                    <th>lab</th>
                    <th>Total fees</th>
                    <th>EDIT</th>
                    <th>DELETE</th>
                    
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>".$row["course_id"]."</td>
                            <td>".$row["course_name"]."</td>
                            <td>".$row["description"]."</td>
                            <td>".$row["registration"]."</td>
                            <td>".$row["tuition"]."</td>
                            <td>".$row["lab"]."</td>
                            <td>".$row["total_fees"]."</td>
                            <td class='center'>
                                <a href='edit.php?course_id=".$row["course_id"]."'>
                                    <button type='submit' class='update'><i class='fas fa-edit'></i></button>
                                </a>
                            </td>
                            <td class='center'>
                            <form method = 'POST' action = 'delete.php'>
                                   
                                    <button type='submit' class='delete' onclick='return checkdelete()' name = 'delete' value = ".$row["course_id"]."><i class='fas fa-trash-alt'></i></button>
                            </form>
                                </a>
                            </td>
                            </td>
                          </tr>";
                }
                ?>
            </table><br><br>
            <?php
                } else {
                    echo "0 results";
                }
                mysqli_close($conn);
           // }
            ?>

            <script>
                function checkdelete() {
                    return confirm('Are you sure you want to delete this record?');
                }
            </script>

          

            <?php 
            } else {
                echo '<script>alert("Login as admin to continue")</script>';
                echo '<script>window.location.href="http://localhost/test/home.php";</script>';
    exit;
            }
            ?>
        </div>
    </div>
    <?php include '../footer.php'; ?>
</body>
</html>
