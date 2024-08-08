<?php
// Including Database configuration file.
include "../connection.php";
// Getting value of "search" variable from "script.js".
if (isset($_POST['search'])) {
    // Search box value assigning to $Name variable.
    $Name = mysqli_real_escape_string($conn, $_POST['search']);

    // Search query.
    if (empty($Name)) {
        // Query to select all records
        $Query = "SELECT e.id, c.course_name, e.full_name, e.email, e.mob, e.demo_date, e.lect_mode, e.add_line, e.add_line2, e.country, e.city, e.region, e.postalcode FROM enquiry e JOIN courses c ON e.course_id = c.course_id LEFT JOIN enrollment en ON e.id = en.enq_id where en.enq_id is null";
    } else {
        // Search query with LIKE clause
        $Query = "SELECT e.id, c.course_name, e.full_name, e.email, e.mob, e.demo_date, e.lect_mode, e.add_line, e.add_line2, e.country, e.city, e.region, e.postalcode FROM enquiry e JOIN courses c ON e.course_id = c.course_id LEFT JOIN enrollment en ON e.id = en.enq_id WHERE e.full_name LIKE '%$Name%' AND en.enq_id is null";
    }
    // Query execution
    $ExecQuery = mysqli_query($conn, $Query);

    // Creating table to display result.
    echo '<table data-table-theme="default zebra">
            <colgroup>
                <col span="1" style="width: 3%;">
                <col span="1" style="width: 5%;">
                <col span="1">
                <col span="1" style="width: 10%;">
                <col span="1" style="width: 6%;"> 
                <col span="1">
                <col span="1">
                <col span="1">
                <col span="1">
                <col span="1">
                <col span="1">
                <col span="1" style="width: 4%;">
                <col span="1" style="width: 4%;">
                <col span="1" style="width: 3%;">
                <col span="1" style="width: 4%;">
                <col span="1" style="width: 4%;">
            </colgroup>
            <tr>
                <th>Enq ID</th>
                <th>Course Name</th>
                <th>FULL NAME</th>
                <th>EMAIL</th>
                <th>MOBILE NUMBER</th>
                <th>DEMO DATE</th>
                <th>MODE</th>
                <th>ADDRESS LINE</th>
                <th>ADDRESS LINE 2</th>
                <th>COUNTRY</th>
                <th>CITY</th>
                <th>REGION</th>
                <th>POST CODE</th>
                <th>EDIT</th>
                <th>DELETE</th>
                <th>ENROLL</th>
            </tr>';

    // Fetching result from database.
    while ($Result = mysqli_fetch_assoc($ExecQuery)) {
        echo "<tr>
                <td>".$Result["id"]."</td>
                <td>".$Result["course_name"]."</td>
                <td>".$Result["full_name"]."</td>
                <td>".$Result["email"]."</td>
                <td>".$Result["mob"]."</td>
                <td>".$Result["demo_date"]."</td>
                <td>".$Result["lect_mode"]."</td>
                <td>".$Result["add_line"]."</td>
                <td>".$Result["add_line2"]."</td>
                <td>".$Result["country"]."</td>
                <td>".$Result["city"]."</td>
                <td>".$Result["region"]."</td>
                <td>".$Result["postalcode"]."</td>
                <td class='center'>
                    <a href='edit.php?id=".$Result["id"]."'>
                        <button type='button' class='update'><i class='fas fa-edit'></i></button>
                    </a>
                </td>
                <td class='center'>
                    <a href='delete.php?id=".$Result["id"]."'>
                        <button type='button' class='delete' onclick='return checkdelete()'><i class='fas fa-trash-alt'></i></button>
                    </a>
                </td>
                <td class='center'>
                    <a href='enroll.php?id=".$Result["id"]."'>
                        <button type='button' class='update'><i class='fas fa-user-plus'></i></button>
                    </a>
                </td>
              </tr>";
    }
    echo "</table><br><br>";
}
?>
