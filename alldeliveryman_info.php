<?php
session_start();
include 'db.php'; // Assuming your db connection is in db.php

// Query to fetch all deliveryman details
$sql = "
    SELECT 
        ID, 
        Name, 
        Phone_Number, 
        Email, 
        Manager_ID
    FROM 
        deliveryman
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Deliverymen Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #b4d2e1ab;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e0f7fa;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>All Deliverymen Information</h1>
    <a href="manager.php"><button style="padding: 10px 20px; font-size: 16px; margin-bottom: 10px; backcolor: #b4d2e1ab; ">Back</button></a>

    <?php
    if ($result->num_rows > 0) {
        // Output the data in an HTML table
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Manager ID</th>
                </tr>";

        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['ID']}</td>
                    <td>{$row['Name']}</td>
                    <td>{$row['Phone_Number']}</td>
                    <td>{$row['Email']}</td>
                    <td>{$row['Manager_ID']}</td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No deliverymen found.</p>";
    }

    $conn->close();
    ?>

</div>
    
</body>
</html>
