<?php
session_start();
include 'db.php';

$sql = "SELECT u.ID, u.name, u.email, u.contact_no, (SELECT GROUP_CONCAT(p.parcel_id) FROM parcel p WHERE p.user_id = u.ID) AS sending_parcels,(SELECT GROUP_CONCAT(p.parcel_id) 
    FROM parcel p WHERE p.receiver_name = u.name) AS receiving_parcels FROM user u
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User and Parcel Information</title>
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
    <h1>User and Parcel Information</h1>
    <a href="manager.php"><button style="padding: 10px 20px; font-size: 16px; margin-bottom: 10px; backcolor: #b4d2e1ab; ">Back</button></a>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact Number</th>
                    <th>Sending Parcel ID(s)</th>
                    <th>Receiving Parcel ID(s)</th>
                </tr>";

        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['ID']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['contact_no']}</td>
                    <td>{$row['sending_parcels']}</td>
                    <td>{$row['receiving_parcels']}</td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No user or parcel information found.</p>";
    }

    $conn->close();
    ?>

</div>

</body>
</html>
