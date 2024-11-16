<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $receiver_name = $_POST['receiver_name'];
    $receiver_phone = $_POST['phone'];
    $weight = $_POST['weight'];
    $type = $_POST['type'];
    $payer = $_POST['payer'];
    $pickup = $_POST['pickup'];
    $destination = $_POST['destination'];

    $user_id = $_SESSION['user_id'];
    $sqlUser = "SELECT * FROM User WHERE ID = '$user_id'";
    $resultUser = $conn->query($sqlUser);
    $sender = $resultUser->fetch_assoc();
    $sender_name = $sender['name'];
    $sender_phone = $sender['contact_no'];

    $sqlDeliveryman = "SELECT ID FROM deliveryman ORDER BY RAND() LIMIT 1";
    $resultDeliveryman = $conn->query($sqlDeliveryman);
    $deliveryman = $resultDeliveryman->fetch_assoc();

    if ($deliveryman) {

        $deliveryman_id = $deliveryman['ID'];

        $sqlInsert = "INSERT INTO parcel (user_id, sender_name, sender_number, pickup_location, weight, receiver_name, receiver_number, delivery_location, parcel_type, deliveryman_id)
                      VALUES ('$user_id', '$sender_name', '$sender_phone', '$pickup', '$weight', '$receiver_name', '$receiver_phone', '$destination', '$type', '$deliveryman_id')";

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parcel Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #b4d2e1ab;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            width: 400px;
            margin: 20px;
        }
        h1 {
            color: #0f506e;
            font-size: 24px;
            margin-bottom: 20px;
            margin: 20px;
        }
        p {
            color: #555;
            font-size: 16px;
        }
        .btn {
            display: inline-block;
            padding: 12px 20px;
            background-color: #0f506e;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: #0d3c4c;
        }
        .error {
            color: red;
            font-size: 18px;
        }

    </style>
</head>
<body>

<div class="container">
    <?php
        if ($conn->query($sqlInsert) === TRUE) {

            $parcel_id = $conn->insert_id;

            $sqlTransactionInsert = "INSERT INTO transaction (Parcel_ID, Status) VALUES ('$parcel_id', 'Pending')";
            if ($conn->query($sqlTransactionInsert) === FALSE) {
                echo "<h1 class='error'>Error Inserting into Transaction Table</h1>";
                echo "<p>Error: " . $sqlTransactionInsert . "<br>" . $conn->error . "</p>";
            }

            $sqlDeliveryInsert = "INSERT INTO delivery (Status, Parcel_ID, Delivery_Location, Pickup_Location, Delivery_Time, deliveryman_id)
                                VALUES ('In Progress', '$parcel_id', '$destination', '$pickup', NOW(), '$deliveryman_id')";

            if ($conn->query($sqlDeliveryInsert) === TRUE) {
                if ($payer === 'Sender') {
                    echo "<h1>Parcel Submitted Successfully!</h1>";
                    echo "<p>Thank you, <strong>$sender_name</strong>. Your parcel request has been successfully submitted.</p>";
                    echo "<p><strong>Parcel ID:</strong> " . $parcel_id . "</p>";
                    echo "<p><strong>Delivery Man ID:</strong> " . $deliveryman_id . "</p>";
                    echo "<a class='btn' href='parcel_confirmation.php?parcel_id=" . $parcel_id . "'>View Confirmation</a>";
                } else {
                    echo "<h1>Parcel Submitted Successfully!</h1>";
                    echo "<p>Thank you, <strong>$sender_name</strong>. Your parcel request has been successfully submitted.</p>";
                    echo "<p><strong>Parcel ID:</strong> " . $parcel_id . "</p>";
                    echo "<p><strong>Delivery Man ID:</strong> " . $deliveryman_id . "</p>";
                    echo "<a class='btn' href='parcel_confirmation_receiver.php?parcel_id=" . $parcel_id . "'>View Confirmation</a>";                    
                }
            } else {
                echo "<h1 class='error'>Error Inserting into Delivery Table</h1>";
                echo "<p>Error: " . $sqlDeliveryInsert . "<br>" . $conn->error . "</p>";
            }
        };

    ?>
    
</div>
</body>
</html>