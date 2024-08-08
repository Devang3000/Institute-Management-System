<?php
include "../connection.php";

$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
$course = isset($_POST['course']) ? $_POST['course'] : '';
$mode = isset($_POST['mode']) ? $_POST['mode'] : '';
$unpaid = isset($_POST['unpaid']) ? $_POST['unpaid'] : '';

$sql = "SELECT e.id, c.course_name, e.full_name, e.email, e.mob, e.lect_mode, e.add_line, e.add_line2, e.country, e.city, e.region, e.postalcode, en.enrollment_id, en.total_fees, en.unpaid 
        FROM enquiry e 
        JOIN courses c ON e.course_id = c.course_id 
        LEFT JOIN enrollment en ON e.id = en.enq_id 
        WHERE en.enrollment_id IS NOT NULL";

if (!empty($keyword)) {
    $sql .= " AND (e.full_name LIKE '%$keyword%' OR e.email LIKE '%$keyword%' OR e.mob LIKE '%$keyword%' OR c.course_name LIKE '%$keyword%')";
}

if (!empty($course)) {
    $sql .= " AND c.course_name = '$course'";
}

if (!empty($mode)) {
    $sql .= " AND e.lect_mode = '$mode'";
}

if (!empty($unpaid)) {
    $sql .= " AND en.unpaid >= $unpaid";
}

$result = mysqli_query($conn, $sql);

$data = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

mysqli_close($conn);

header('Content-Type: application/json');
echo json_encode($data);
?>
