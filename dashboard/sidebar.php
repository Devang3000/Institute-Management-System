<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Document</title>
    <style>
      
      .myapp-sidebar {
        width: 250px;
        background-color: #2c3e50;
        color: white;
        padding: 35px;
        height: 100vh;
        overflow-y: clip;
        z-index: 600;
        align-self: flex-start;
        position: sticky;
        top: 0;
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
    }

    </style>
</head>
<body>
<div class = "wrapper">
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul>
            <li><a href="#overview">Dashboard Overview</a></li>
            <li><a href="#courses">Courses</a></li>
            <li><a href="#fees">Fees</a></li>
            <li><a href="../enrolledstudents.php">Enrollments</a></li>
            <li><a href="../display.php">Enquiries</a></li>
            <li><a href="#payments">Payments</a></li>
            <li><a href="#admin-accounts">Admin Accounts</a></li>
            <li><a href="#student-logins">Student Logins</a></li>
        </ul>
    </div>

</body>
</html>