<?php
include("header.php");
include("connection.php");

if (!isset($_SESSION["user"])) {
    die("User not logged in.");
}

$id = intval($_SESSION["user"]); // Secure the user's enrollment ID from session

// Fetch user details
$sql_query = "SELECT e.total_fees, 
(SELECT COALESCE(SUM(payment_amount), 0) 
FROM payments WHERE enrollment_id = ?) 
as total_paid, en.full_name, en.email, e.enrollment_id 
FROM enrollment e 
JOIN enquiry en 
ON e.enq_id = en.id 
WHERE e.enrollment_id = ?";

$stmt = $conn->prepare($sql_query);
$stmt->bind_param("ii", $id, $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("User not found.");
}

$total_fees = $user['total_fees'];
$total_paid = $user['total_paid'];
$remaining_fees = $total_fees - $total_paid;

if ($remaining_fees <= 0) {
    die("No fees remaining to be paid.");
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pay Fees</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 250px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        label {
            font-size: 18px;
            color: #555;
            margin-bottom: 10px;
        }
        input[type="number"] {
            padding: 10px;
            font-size: 16px;
            width: 100%;
            max-width: 300px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
        h2{
            align-content: center;

        }
    </style>
</head>
<body>
    <div class="container">
        
        <div>
        <form action="process_payment.php" method="POST" id="payment-form">
        <h2>Pay Your Fees</h2>
            <label for="amount">Amount to Pay:</label>
            <input type="number" id="amount" name="amount" value = "<?php echo $remaining_fees?>" max="<?php echo $remaining_fees ; ?>" required>
            <button type="button" id="rzp-button">Pay with Razorpay</button>
        </form>
        </div>
    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        document.getElementById('rzp-button').onclick = function(e) {
            var amount = document.getElementById('amount').value;
            var options = {
                "key": "rzp_test_b4ErrgywyBpny5", // Enter the Key ID generated from the Dashboard
                "amount": amount * 100, // Amount in paise
                "currency": "INR",
                "name": "Your Company Name",
                "description": "Fee Payment enrollment_id=<?php echo $user['enrollment_id']; ?>",
                "handler": function (response){
                    // Send payment details to server
                    var form = document.getElementById('payment-form');
                    var input = document.createElement("input");
                    input.setAttribute("type", "hidden");
                    input.setAttribute("name", "razorpay_payment_id");
                    input.setAttribute("value", response.razorpay_payment_id);
                    form.appendChild(input);
                    form.submit();
                },
                "prefill": {
                    "name": "<?php echo htmlspecialchars($user['full_name']); ?>",
                    "email": "<?php echo htmlspecialchars($user['email']); ?>"
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.open();
            e.preventDefault();
        }
    </script>
   
</body>
</html>
<br><br><br><br><br>
<?php include("footer.php");?>