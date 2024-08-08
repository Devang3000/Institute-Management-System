<?php
include("header.php");
include("connection.php");

// Retrieve student enrollment ID from the URL parameter
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Validate input
if ($id <= 0) {
    die("Invalid student enrollment ID.");
}

// Fetch payment records for the student
$sql_payments = "SELECT * FROM payments WHERE enrollment_id = '$id' order by payment_id desc";
$payment_data = mysqli_query($conn, $sql_payments);

if (!$payment_data) {
    die("Error fetching payment records: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fee Receipts</title>
    <style>
        /* Receipt CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .headerf {
            font-size: 1.5rem;
            color: #333;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<!-- Fee receipts content -->
<section class="container">
    
<table>
    <tr>
        <th style ="text-align:center" colspan="3" class="center"  ><headerf>Fees Receipt</headerf></th>
    </tr>
    <tr>
        <th style ="text-align:center" colspan="3" class="center"><headerf>abc institute</headerf></th>
    </tr>
    <tr>
        <th>Payment ID</th>
        <th>Payment Amount</th>
        <th>Payment Date</th>
    </tr>
        <?php while ($row = mysqli_fetch_assoc($payment_data)) { ?>
            <tr>
                <td><?php echo $row['payment_id']; ?></td>
                <td><?php echo $row['payment_amount']; ?></td>
                <td><?php echo $row['payment_date']; ?></td>
            </tr>
        <?php } ?>
    </table>
</section>

</body>
</html>

<?php
include("footer.php");
?>
