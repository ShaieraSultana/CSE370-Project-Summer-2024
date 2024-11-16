<?php
session_start();
include 'db.php';

if (!isset($_SESSION['staff_id'])) {
    header("Location: login.php");
    exit();
}

$staff_id = $_SESSION['staff_id'];
$sql = "SELECT * FROM staff WHERE ID = '$staff_id'";
$result = $conn->query($sql);
$staff = $result->fetch_assoc();

// Query to get the hotline number from the customercare table
$sql_hotline = "SELECT Hotline_Number FROM customercare WHERE ID = '$staff_id'";
$result_hotline = $conn->query($sql_hotline);
$hotline_info = $result_hotline->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Care</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #b4d2e1ab;
            margin: 0;
        }
        .welcome-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 400px;
            margin: 50px auto;
        }
        h1 {
            color: #0f506e;
            margin-bottom: 20px;
            font-size: 20px;
        }
        .user-info {
            text-align: left;
            margin: 20px 0;
            font-size: 18px;
            color: #333;
        }
        .logout-btn {
            background-color: #0f506e;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            margin: 10px;
        }
        .logout-btn:hover {
            background-color: #0d3c4c;
        }
        .notification-bar {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            cursor: pointer;
            margin: 20px;
        }
        .next-btn {
            padding: 10px;
            margin-left: 9px;
        }
    </style>
</head>
<body>
    <div class='notification-bar'> 
        <h1>Customer Care Dashboard</h1>
    </div>
    <div class="welcome-container">
        <h1>Welcome, <?php echo htmlspecialchars($staff['Name']); ?>!</h1>
        <div class="user-info">
            <p><strong>User ID:</strong> <?php echo htmlspecialchars($staff['ID']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($staff['Email']); ?></p>
            <p><strong>Hotline Number Attending:</strong> <?php echo htmlspecialchars($hotline_info['Hotline_Number']); ?></p>
            <a href="allparcel_info.php"><button style="padding: 10px 20px; font-size: 16px; margin-bottom: 10px; margin-left: 9px;">View Parcel Information</button></a>
            <a href="alldeliveryman_info.php"><button style="padding: 10px 20px; font-size: 16px; margin-bottom: 10px; margin-left: 9px;">View Delivery Man Information</button></a>
            <a href="alluser_info.php"><button style="padding: 10px 20px; font-size: 16px; margin-bottom: 10px; margin-left: 9px;">View User Information</button></a>
            <form action="logout.php" method="POST" style="display: inline;">
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>
