<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM User WHERE email = '$email' ";
    $result = $conn->query($sql);

        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['ID'];
        $_SESSION['user_name'] = $user['name'];

}

$user_name = $_SESSION['user_name'];


$query_receiver = "
    SELECT p.*, d.Status AS Status
    FROM parcel p
    LEFT JOIN delivery d ON p.parcel_id = d.Parcel_ID
    WHERE receiver_name = ?";
$stmt_receiver = $conn->prepare($query_receiver);
$stmt_receiver->bind_param("s", $user_name);
$stmt_receiver->execute();
$result_receiver = $stmt_receiver->get_result();

$query_sender = "
    SELECT p.*, d.Status AS Status
    FROM parcel p
    LEFT JOIN delivery d ON p.parcel_id = d.Parcel_ID
    WHERE sender_name = ?";
$stmt_sender = $conn->prepare($query_sender);
$stmt_sender->bind_param("s", $user_name);
$stmt_sender->execute();
$result_sender = $stmt_sender->get_result();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parcel Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #b4d2e1ab;
            padding: 20px;
        }
        .parcel-box {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>

<h1>Parcel Status for: <?php echo htmlspecialchars($user_name); ?></h1>

<div class="parcel-box">
    <h2>Parcels Where You Are the Receiver</h2>
    <?php if ($result_receiver->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Parcel ID</th>
                    <th>Sender Name</th>
                    <th>Sender Number</th>
                    <th>Pickup Location</th>
                    <th>Weight (kg)</th>
                    <th>Delivery Location</th>
                    <th>Parcel Type</th>
                    <th>Delivery Man</th>
                    <th>Transaction Status</th>
                    <th>Delivery Status</th>
                    <th>Payment</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_receiver->fetch_assoc()): ?>
                    <?php

                    $parcel_id = $row['parcel_id'];
                    $deliveryman_id = $row['deliveryman_id'];

                    $delivery_query = "SELECT * FROM deliveryman WHERE ID = ?";
                    $delivery_stmt = $conn->prepare($delivery_query);
                    $delivery_stmt->bind_param("s", $deliveryman_id);
                    $delivery_stmt->execute();
                    $delivery_result = $delivery_stmt->get_result();
                    $deliveryman = $delivery_result->fetch_assoc();

                    $transaction_query = "SELECT status FROM transaction WHERE Parcel_ID = ?";
                    $transaction_stmt = $conn->prepare($transaction_query);
                    $transaction_stmt->bind_param("i", $parcel_id);
                    $transaction_stmt->execute();
                    $transaction_result = $transaction_stmt->get_result();
                    $transaction = $transaction_result->fetch_assoc();
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['parcel_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['sender_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['sender_number']); ?></td>
                        <td><?php echo htmlspecialchars($row['pickup_location']); ?></td>
                        <td><?php echo htmlspecialchars($row['weight']); ?></td>
                        <td><?php echo htmlspecialchars($row['delivery_location']); ?></td>
                        <td><?php echo htmlspecialchars($row['parcel_type']); ?></td>
                        <td>
                            <?php if ($deliveryman): ?>
                                Name: <?php echo htmlspecialchars($deliveryman['Name']); ?><br>
                                Phone: <?php echo htmlspecialchars($deliveryman['Phone_Number']); ?><br>
                                Email: <?php echo htmlspecialchars($deliveryman['Email']); ?>
                            <?php else: ?>
                                Not Assigned
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo $transaction ? htmlspecialchars($transaction['status']) : 'No Transaction'; ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($row['Status']); ?>
                        </td>
                        <td>
                            <?php if ($transaction && $transaction['status'] == 'Pending'): ?>
                                <button onclick="window.location.href='transaction.php?parcel_id=<?php echo htmlspecialchars($row['parcel_id']); ?>'">
                                    Make Payment
                                </button>
                            <?php else: ?>
                                Paid
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No parcels found where you are the receiver.</p>
    <?php endif; ?>
</div>


<div class="parcel-box">
    <h2>Parcels Where You Are the Sender</h2>
    <?php if ($result_sender->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Parcel ID</th>
                    <th>Receiver Name</th>
                    <th>Receiver Number</th>
                    <th>Delivery Location</th>
                    <th>Weight (kg)</th>
                    <th>Parcel Type</th>
                    <th>Delivery Man</th>
                    <th>Transaction Status</th>
                    <th>Delivery Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result_sender->fetch_assoc()): ?>
                    <?php
                    $parcel_id = $row['parcel_id'];
                    $deliveryman_id = $row['deliveryman_id'];

                    $delivery_query = "SELECT * FROM deliveryman WHERE ID = ?";
                    $delivery_stmt = $conn->prepare($delivery_query);
                    $delivery_stmt->bind_param("s", $deliveryman_id);
                    $delivery_stmt->execute();
                    $delivery_result = $delivery_stmt->get_result();
                    $deliveryman = $delivery_result->fetch_assoc();


                    $transaction_query = "SELECT status FROM transaction WHERE Parcel_ID = ?";
                    $transaction_stmt = $conn->prepare($transaction_query);
                    $transaction_stmt->bind_param("i", $parcel_id);
                    $transaction_stmt->execute();
                    $transaction_result = $transaction_stmt->get_result();
                    $transaction = $transaction_result->fetch_assoc();
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['parcel_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['receiver_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['receiver_number']); ?></td>
                        <td><?php echo htmlspecialchars($row['delivery_location']); ?></td>
                        <td><?php echo htmlspecialchars($row['weight']); ?></td>
                        <td><?php echo htmlspecialchars($row['parcel_type']); ?></td>
                        <td>
                            <?php if ($deliveryman): ?>
                                Name: <?php echo htmlspecialchars($deliveryman['Name']); ?><br>
                                Phone: <?php echo htmlspecialchars($deliveryman['Phone_Number']); ?><br>
                                Email: <?php echo htmlspecialchars($deliveryman['Email']); ?>
                            <?php else: ?>
                                Not Assigned
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo $transaction ? htmlspecialchars($transaction['status']) : 'No Transaction'; ?>
                        </td>
                        <td>
                            <?php echo htmlspecialchars($row['Status']); ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No parcels found where you are the sender.</p>
    <?php endif; ?>
</div>

<div style="text-align: center; margin-top: 20px;">
    <form action="welcome.php" method="get">
        <button type="submit" style="padding: 10px 20px; font-size: 16px;">Back to Home</button>
    </form>
</div>

</body>
</html>

<?php
$stmt_receiver->close();
$stmt_sender->close();
$conn->close();
?>