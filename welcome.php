<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM User WHERE ID = '$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

$sqlParcels = "SELECT * FROM Parcel WHERE user_id = '$user_id'";
$resultParcels = $conn->query($sqlParcels);
$parcels = $resultParcels->fetch_all(MYSQLI_ASSOC);
$hasParcel = !empty($parcels);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
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
            margin:20px;
        }
        .next-btn {
            padding: 10px;
            margin-left: 9px;
        }

    </style>
</head>
<body>

    <div class="notification-bar" onclick="window.location.href='parcel_status.php'">
            <i class="fas fa-inbox" style="color: <?php echo $hasParcel ? 'green' : 'gray'; ?>;"><h3>Parcel Information</h3></i>
            
    </div>

    <div class="welcome-container">
        <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
        <div class="user-info">
            <p><strong>User ID:</strong> <?php echo htmlspecialchars($user['ID']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Contact No:</strong> <?php echo htmlspecialchars($user['contact_no']); ?></p>
        </div>
        <a href="next_page.php"><button class="next-btn">Create a Parcel</button></a>
        
        <form action="logout.php" method="POST" style="display: inline;">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
        <a href="hotline.php"><button class="next-btn">Facing any issue?</button></a>


    </div>
</body>
</html>
