<?php
include 'db.php';
$pickup = isset($_GET['pickup']) ? $_GET['pickup'] : '';
$destination = isset($_GET['destination']) ? $_GET['destination'] : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parcel Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            font-size: 16px;
            color: #555;
            margin-bottom: 5px;
        }

        .input-group input,
        .input-group select {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background-color: #0f506e;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }

        .submit-btn:hover {
            background-color: #0d3c4c;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Parcel and Transaction Information</h2>

    <form action="submit_parcel.php" method="POST">

        <div class="input-group">
            <label for="receiver-name">Receiver's Name</label>
            <input type="text" id="receiver-name" name="receiver_name" placeholder="Enter Receiver's Name" required>
        </div>

        <div class="input-group">
            <label for="phone">Receiver's Phone No.</label>
            <input type="text" id="phone" name="phone" placeholder="Enter Phone Number" required>
        </div>

        <div class="input-group">
            <label for="weight">Parcel Weight (kg)</label>
            <input type="text" id="weight" name="weight" placeholder="Enter Parcel Weight" required>
        </div>

        <div class="input-group">
            <label for="type">Parcel Type</label>
            <input type="text" id="type" name="type" placeholder="Enter Parcel Type" required>
        </div>

        <h3>Transaction Details</h3>

        <div class="input-group">
            <label>Who will pay?</label>
            <select name="payer" required>
                <option value="Sender">Sender</option>
                <option value="Receiver">Receiver</option>
            </select>
        </div>

        <input type="hidden" name="pickup" value="<?php echo htmlspecialchars($pickup); ?>">
        <input type="hidden" name="destination" value="<?php echo htmlspecialchars($destination); ?>">
        <button class="submit-btn" type="submit">Submit Parcel</button>
    </form>
</div>

<div style="text-align: center; margin-top: 20px;">
    <form action="welcome.php" method="get">
        <button type="submit" style="padding: 10px 20px; font-size: 16px;">Back to Home</button>
    </form>
</div>

</body>
</html>