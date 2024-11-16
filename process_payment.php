<?php
include 'db.php';
$parcel_id = isset($_GET['parcel_id']) ? $_GET['parcel_id'] : '';

if (!empty($parcel_id)) {
    $updateTransaction = "UPDATE Transaction SET Status = 'Done' WHERE Parcel_ID = '$parcel_id' AND Status = 'Pending'";

    if ($conn->query($updateTransaction) === TRUE) {
        echo "<p>Transaction updated successfully.</p>";
    } else {
        echo "<p>Error updating transaction: " . $conn->error . "</p>";
    }
}



$message = "Thank you for your order!";


    if (isset($_POST['card-number'])) {
        $cardNumber = $_POST['card-number'];
        $cardHolder = $_POST['card-holder'];
        $expiry = $_POST['expiry'];
        $cvv = $_POST['cvv'];
        $message = "Payment successful! Your card number: " . htmlspecialchars($cardNumber);
    } elseif (isset($_POST['bkash-number'])) {
        $bkashNumber = $_POST['bkash-number'];
        $transactionId = $_POST['transaction-id'];
        $message = "Payment successful! Transaction ID: " . htmlspecialchars($transactionId);
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Processed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .colorbox {
            background-color: #b4d2e1ab;
            padding: 20px;
        }

        .message {
            margin: 20px 0;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class='colorbox'>

    <h1>Payment Processed</h1>

    <div class="message">
        <?php echo htmlspecialchars($message); ?>
    </div>

    <a href="welcome.php">Back to home</a>
</div>
</body>
</html>
