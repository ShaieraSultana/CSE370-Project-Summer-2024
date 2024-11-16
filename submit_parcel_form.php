<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $receiver_name = isset($_POST['receiver_name']) ? htmlspecialchars($_POST['receiver_name']) : '';
    $phone = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
    $weight = isset($_POST['weight']) ? htmlspecialchars($_POST['weight']) : '';
    $type = isset($_POST['type']) ? htmlspecialchars($_POST['type']) : '';
    $pickup = isset($_POST['pickup']) ? htmlspecialchars($_POST['pickup']) : '';
    $destination = isset($_POST['destination']) ? htmlspecialchars($_POST['destination']) : '';
} else {
    header('Location: parcel_info.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parcel Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .confirmation-container {
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

        .parcel-info {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .parcel-info li {
            margin-bottom: 10px;
        }

        .parcel-info li strong {
            color: #555;
        }

        .back-btn {
            width: 100%;
            padding: 12px;
            background-color: #0f506e;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            margin-top: 20px;
        }

        .back-btn:hover {
            background-color: #0d3c4c;
        }
    </style>
</head>
<body>

<div class="confirmation-container">
    <h2>Parcel Information Confirmed</h2>
    <ul class="parcel-info">
        <li><strong>Receiver's Name:</strong> <?php echo $receiver_name; ?></li>
        <li><strong>Phone Number:</strong> <?php echo $phone; ?></li>
        <li><strong>Parcel Weight:</strong> <?php echo $weight; ?> kg</li>
        <li><strong>Parcel Type:</strong> <?php echo $type; ?></li>
        <li><strong>Pickup Location:</strong> <?php echo $pickup; ?></li>
        <li><strong>Destination:</strong> <?php echo $destination; ?></li>
    </ul>
    
    <button class="back-btn" onclick="window.location.href='welcome.php';">Back to Home</button>
</div>

</body>
</html>
