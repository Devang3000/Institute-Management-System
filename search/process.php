

<?php
include("../connection.php");




if(1==1) {
    
    $filter_enrolled = isset($_POST['enrolled']) && $_POST['enrolled'] === 'enrolled';

    $sql = "SELECT
                e.id,
                c.course_name,
                e.full_name,
                e.email,
                e.mob,
                e.demo_date,
                e.lect_mode,
                e.add_line,
                e.add_line2,
                e.country,
                e.city,
                e.region,
                e.postalcode
            FROM
                enquiry e
            JOIN
                courses c ON e.course_id = c.course_id
            LEFT JOIN
                enrollment en ON e.id = en.enq_id";

    
       
  
        $sql .= " WHERE en.enq_id IS NULL";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
?>
<table data-table-theme="default zebra">
    <colgroup>
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
    </tr>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>".$row["id"]."</td>
                <td>".$row["course_name"]."</td>
                <td>".$row["full_name"]."</td>
                <td>".$row["email"]."</td>
                <td>".$row["mob"]."</td>
                <td>".$row["demo_date"]."</td>
                <td>".$row["lect_mode"]."</td>
                <td>".$row["add_line"]."</td>
                <td>".$row["add_line2"]."</td>
                <td>".$row["country"]."</td>
                <td>".$row["city"]."</td>
                <td>".$row["region"]."</td>
                <td>".$row["postalcode"]."</td>
                <td class='center'>
                    <a href='edit.php?id=".$row["id"]."'>
                        <button type='button' class='update'><i class='fas fa-edit'></i></button>
                    </a>
                </td>
                <td class='center'>
                    <a href='delete.php?id=".$row["id"]."'>
                        <button type='button' class='delete' onclick='return checkdelete()'><i class='fas fa-trash-alt'></i></button>
                    </a>
                </td>
                <td class='center'>
                    <a href='enroll.php?id=".$row["id"]."'>
                        <button type='button' class='update'><i class='fas fa-user-plus'></i></button>
                    </a>
                </td>
              </tr>";
    }
    ?>
</table><br><br>
<?php
    } else {
        echo "0 results";
    }
}









?>