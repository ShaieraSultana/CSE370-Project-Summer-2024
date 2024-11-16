<?php
session_start();
include 'db.php';

if (!isset($_SESSION['deliveryman_id'])) {
    header("Location: login.html");
    exit();
}

$deliveryman_id = $_SESSION['deliveryman_id'];

if (isset($_POST['parcel_id'])) {
    $parcel_id = $_POST['parcel_id'];

    $update_query = "UPDATE delivery SET Status = 'Completed' WHERE Parcel_ID = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("i", $parcel_id);
    $stmt->execute();

    $update_transaction_query = "UPDATE transaction SET Status = 'Done' WHERE Parcel_ID = ?";
    $stmt_transaction = $conn->prepare($update_transaction_query);
    $stmt_transaction->bind_param("i", $parcel_id);
    $stmt_transaction->execute();
}

$query = "
    SELECT p.*, d.Status AS delivery_status, t.Status AS transaction_status
    FROM parcel p
    LEFT JOIN delivery d ON p.parcel_id = d.Parcel_ID
    LEFT JOIN transaction t ON p.parcel_id = t.Parcel_ID
    WHERE p.deliveryman_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $deliveryman_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Assigned Deliveries</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background-color:#b4d2e1ab;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 4px;
        }
        button:hover {
            background-color: #218838;
        }
        .no-data {
            text-align: center;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your Assigned Deliveries</h2>
        <table>
            <thead>
                <tr>
                    <th>Parcel ID</th>
                    <th>Sender Name</th>
                    <th>Receiver Name</th>
                    <th>Weight</th>
                    <th>Pickup Location</th>
                    <th>Delivery Location</th>
                    <th>Delivery Status</th>
                    <th>Transaction Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['parcel_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['sender_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['receiver_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['weight']); ?> kg</td>
                            <td><?php echo htmlspecialchars($row['pickup_location']); ?></td>
                            <td><?php echo htmlspecialchars($row['delivery_location']); ?></td>
                            <td>
                                <?php if ($row['delivery_status'] === 'Completed'): ?>
                                    <span>Completed</span>
                                <?php else: ?>
                                    <form method="POST" action="">
                                        <input type="hidden" name="parcel_id" value="<?php echo $row['parcel_id']; ?>">
                                        <button type="submit">Done</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['transaction_status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="no-data">No assigned deliveries found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="deliverymanhome.php"><button style="padding: 10px 20px; font-size: 16px; margin-bottom: 10px; backcolor: #b4d2e1ab; ">Back</button></a>
    </div>
</body>
</html>
