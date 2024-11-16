<?php
session_start();
include 'db.php';

$sql = "SELECT p.parcel_id, p.user_id, p.sender_number, p.sender_name, p.pickup_location, p.weight, p.receiver_name, p.receiver_number, p.delivery_location, p.parcel_type, p.deliveryman_id,
        d.Status AS delivery_status, t.Status AS transaction_status FROM parcel p 
        LEFT JOIN delivery d ON p.parcel_id = d.Parcel_ID 
        LEFT JOIN transaction t ON p.parcel_id = t.Parcel_ID ";

$result = $conn->query($sql);
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
            background-color: #b4d2e1ab;
            margin: 0;
            padding: 20px;
        }
        .container {
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #333;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #5a9bb5;
            color: white;
        }
        tr:hover {
            background-color: #e0f7fa;
        }

    </style>
</head>
<body>

<div class="container">
    <h1>Parcel Information</h1>
    <a href="manager.php"><button style="padding: 10px 20px; font-size: 16px; margin-bottom: 10px; backcolor: #b4d2e1ab; ">Back</button></a>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Parcel ID</th>
                    <th>User ID</th>
                    <th>Sender Number</th>
                    <th>Sender Name</th>
                    <th>Pickup Location</th>
                    <th>Weight</th>
                    <th>Receiver Name</th>
                    <th>Receiver Number</th>
                    <th>Delivery Location</th>
                    <th>Parcel Type</th>
                    <th>Deliveryman ID</th>
                    <th>Delivery Status</th>
                    <th>Transaction Status</th>
                </tr>";

        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['parcel_id']}</td>
                    <td>{$row['user_id']}</td>
                    <td>{$row['sender_number']}</td>
                    <td>{$row['sender_name']}</td>
                    <td>{$row['pickup_location']}</td>
                    <td>{$row['weight']}</td>
                    <td>{$row['receiver_name']}</td>
                    <td>{$row['receiver_number']}</td>
                    <td>{$row['delivery_location']}</td>
                    <td>{$row['parcel_type']}</td>
                    <td>{$row['deliveryman_id']}</td>
                    <td>{$row['delivery_status']}</td>
                    <td>{$row['transaction_status']}</td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No parcels found.</p>";
    }

    $conn->close();
    ?>

</div>

</body>
</html>
