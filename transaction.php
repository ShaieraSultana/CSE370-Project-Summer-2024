<?php
$parcel_id = $_GET['parcel_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .colorbox {
            background-color: #b4d2e1ab;
            padding: 20px;
        }

        .payment-method {
            margin-bottom: 20px;
        }

        .form-section {
            display: none;
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="number"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px 15px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<div class='colorbox'>
    <h1>Transaction Page</h1>
    <p>Select a payment method and fill in the necessary details.</p>

    <div class="payment-method">
        <label for="payment">Choose a payment method:</label>
        <select id="payment" onchange="showForm(this.value)">
            <option value="">--Select Payment Method--</option>
            <option value="card">Card</option>
            <option value="bkash">bKash</option>
            <option value="cash">Cash</option>
        </select>
    </div>

    <div id="card" class="form-section">
        <h2>Card Payment. Transfer money to : ac:0123456789</h2>
        <form action="process_payment.php" method="POST">

            <label for="card-number">Card Number:</label>
            <input type="text" id="card-number" name="card-number" placeholder="1234 5678 9123 4567" required>

            <label for="card-holder">Cardholder Name:</label>
            <input type="text" id="card-holder" name="card-holder" placeholder="John Doe" required>

            <label for="expiry">Expiry Date:</label>
            <input type="text" id="expiry" name="expiry" placeholder="MM/YY" required>

            <label for="cvv">CVV:</label>
            <input type="number" id="cvv" name="cvv" placeholder="123" required>

            <a href="process_payment.php?parcel_id=<?php echo $parcel_id; ?>">Confirm Order</a>
        </form>
    </div>

    <div id="bkash" class="form-section">
        <h2>bKash Payment. Make payment at: 1800-222-3456 </h2>
        <form action="process_payment.php" method="POST">
            <label for="bkash-number">bKash Account Number:</label>
            <input type="text" id="bkash-number" name="bkash-number" placeholder="01XXXXXXXXX" required>

            <label for="transaction-id">bKash Transaction ID:</label>
            <input type="text" id="transaction-id" name="transaction-id" placeholder="Enter Transaction ID" required>

            <a href="process_payment.php?parcel_id=<?php echo $parcel_id; ?>">Confirm Order</a>
        </form>
    </div>

    <div id="cash" class="form-section">
        <h2>Cash Payment</h2>
        <form action="process_payment.php" method="POST">
            <p>You have selected to pay by cash. Please keep the exact amount ready at the time of delivery.</p>
            <a href="process_payment.php?parcel_id=<?php echo $parcel_id; ?>">Confirm Order</a>
        </form>
    </div>

    <script>
        function showForm(paymentMethod) {
            document.getElementById("card").style.display = "none";
            document.getElementById("bkash").style.display = "none";
            document.getElementById("cash").style.display = "none";

            if (paymentMethod) {
                document.getElementById(paymentMethod).style.display = "block";
            }
        }
    </script>
    <h1>
</div>
</body>
</html>
