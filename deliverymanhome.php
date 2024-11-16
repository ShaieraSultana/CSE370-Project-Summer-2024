<?php
session_start();
include 'db.php';

// Check if the deliveryman is logged in
if (!isset($_SESSION['deliveryman_id'])) {
    header("Location: login.html");
    exit();
}

// Get deliveryman name and ID from session
$deliveryman_name = isset($_SESSION['deliveryman_name']) ? $_SESSION['deliveryman_name'] : 'Rider';
$deliveryman_id = isset($_SESSION['deliveryman_id']) ? $_SESSION['deliveryman_id'] : 'Unknown ID';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deliveryman Home</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 80px auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 20px;
        }

        h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }

        p {
            font-size: 18px;
            color: #666;
        }

        button {
            background-color: #5cb85c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }

        button:hover {
            background-color: #4cae4c;
        }

        .assigned-work-btn {
            display: block;
            width: 100%;
            margin-top: 20px;
        }

        .logo {
            display: block;
            margin: 0 auto 20px auto;
            width: 120px;
        }

        .footer {
            margin-top: 30px;
            color: #999;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="logo.png" alt="Company Logo" class="logo">

        <h2>Welcome, <?php echo htmlspecialchars($deliveryman_name); ?></h2>
        <p>Your ID: <?php echo htmlspecialchars($deliveryman_id); ?></p>
        
        <form action="assignedwork.php" method="get">
            <button type="submit" class="assigned-work-btn">Your Assigned Deliveries</button>
        </form>
        
        </div>
    </div>
</body>
</html>