<?php
include 'db.php';

$parcel_id = $_GET['parcel_id'];


$sqlParcel = "SELECT * FROM Parcel WHERE parcel_id = '$parcel_id'";
$resultParcel = $conn->query($sqlParcel);
$parcel = $resultParcel->fetch_assoc();

$sqlTransaction = "SELECT * FROM Transaction WHERE Parcel_ID = '$parcel_id'";
$resultTransaction = $conn->query($sqlTransaction);
$transaction = $resultTransaction->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parcel Confirmation</title>
    <style>
        .container {
                background-color: #fff;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
                text-align: center;
                width: 400px;
                margin: 20px;
                background-color: #b4d2e1ab;
                padding: 20px;
        }
        h1 {
                color: #0f506e;
                font-size: 24px;
                margin-bottom: 20px;
                margin: 20px;
        }

        a  {
                font-size: 20px;
                padding: 20px
        }

    </style>
</head>
<body>


    <div class='container'>
        <h2>Parcel Confirmation</h2>

        <h3>Parcel Information</h3>
        <p><strong>Sender Name:</strong> <?php echo $parcel['sender_name']; ?></p>
        <p><strong>Receiver Name:</strong> <?php echo $parcel['receiver_name']; ?></p>
        <p><strong>Pickup Location:</strong> <?php echo $parcel['pickup_location']; ?></p>
        <p><strong>Delivery Location:</strong> <?php echo $parcel['delivery_location']; ?></p>
        <p><strong>Weight:</strong> <?php echo $parcel['weight']; ?> kg</p>
        <p><strong>Parcel Type:</strong> <?php echo $parcel['parcel_type']; ?></p>
    </div>

    <div class='container'>
        <h1>Total Charge: 200 TK</h1>
        <h1>Rider will collect the money from receiver</h1>
        <a href="welcome.php"><button class="home-btn">Go to Home</button></a>

</body>
</html>
