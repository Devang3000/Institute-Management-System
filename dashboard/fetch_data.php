<style>
    .pagination {
    text-align: center;
    margin-top: 10px;
}

.pagination a, .pagination .current {
    display: inline-block;
    padding: 5px 10px;
    margin: 0 2px;
    border: 1px solid #ccc;
    background-color: #f9f9f9;
    color: #333;
    text-decoration: none;
}

.pagination .current {
    font-weight: bold;
    background-color: #333;
    color: #fff;
}

.pagination a:hover {
    background-color: #ddd;
}
</style>
<?php
include('../connection.php');

$section = $_GET['section'];
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$recordsPerPage = 10;
$startRecord = ($page - 1) * $recordsPerPage;

if ($section == 'payments') {
    $totalPayments = $conn->query("SELECT COUNT(*) as count FROM payments")->fetch_assoc()['count'];
    $result = $conn->query("SELECT * FROM payments LIMIT $startRecord, $recordsPerPage");

    if ($result->num_rows > 0) {
        echo "<table><tr><th>Payment ID</th><th>Enrollment ID</th><th>Payment Amount</th><th>Payment Date</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['payment_id']}</td><td>{$row['enrollment_id']}</td><td>{$row['payment_amount']}</td><td>{$row['payment_date']}</td></tr>";
        }
        echo "</table>";
        
        $totalPages = ceil($totalPayments / $recordsPerPage);

        // Pagination links
        echo '<div class="pagination">';
        if ($page > 1) {
            echo "<a href='#' class='pagination-link' data-section='payments' data-page='1'>First</a>";
            echo "<a href='#' class='pagination-link' data-section='payments' data-page='".($page - 1)."'>Prev</a>";
        }
        for ($i = max(1, $page - 5); $i <= min($page + 5, $totalPages); $i++) {
            if ($i == $page) {
                echo "<span class='current'>$i</span>";
            } else {
                echo "<a href='#' class='pagination-link' data-section='payments' data-page='$i'>$i</a>";
            }
        }
        if ($page < $totalPages) {
            echo "<a href='#' class='pagination-link' data-section='payments' data-page='".($page + 1)."'>Next</a>";
            echo "<a href='#' class='pagination-link' data-section='payments' data-page='$totalPages'>Last</a>";
        }
        echo '</div>';
    } else {
        echo "No payments found.";
    }
} elseif ($section == 'student_logins') {
    $totalStudents = $conn->query("SELECT COUNT(*) as count FROM studentlogin")->fetch_assoc()['count'];
    $result = $conn->query("SELECT * FROM studentlogin LIMIT $startRecord, $recordsPerPage");

    if ($result->num_rows > 0) {
        echo "<table><tr><th>Login ID</th><th>Enrollment ID</th><th>Password</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['login_id']}</td><td>{$row['enrollment_id']}</td><td>{$row['password']}</td></tr>";
        }
        echo "</table>";
        
        $totalPages = ceil($totalStudents / $recordsPerPage);

        // Pagination links
        echo '<div class="pagination">';
        if ($page > 1) {
            echo "<a href='#' class='pagination-link' data-section='student_logins' data-page='1'>First</a>";
            echo "<a href='#' class='pagination-link' data-section='student_logins' data-page='".($page - 1)."'>Prev</a>";
        }
        for ($i = max(1, $page - 5); $i <= min($page + 5, $totalPages); $i++) {
            if ($i == $page) {
                echo "<span class='current'>$i</span>";
            } else {
                echo "<a href='#' class='pagination-link' data-section='student_logins' data-page='$i'>$i</a>";
            }
        }
        if ($page < $totalPages) {
            echo "<a href='#' class='pagination-link' data-section='student_logins' data-page='".($page + 1)."'>Next</a>";
            echo "<a href='#' class='pagination-link' data-section='student_logins' data-page='$totalPages'>Last</a>";
        }
        echo '</div>';
    } else {
        echo "No student logins found.";
    }
}
?>

