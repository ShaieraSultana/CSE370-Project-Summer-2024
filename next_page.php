<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Your Parcel</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .parcel-container {
            background-color: #b4d2e1ab;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 400px;
        }
        h1 {
            color: #0f506e;
            margin-bottom: 20px;
        }
        .delivery-btn {
            background-color: #0f506e;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 10px;
            width: 150px;
        }
        .delivery-btn:hover {
            background-color: #0d3c4c;
        }
    </style>
</head>
<body>
    <div class="parcel-container">
        <h1>Send Your Parcel</h1>
        <h2>by Your Reliable Delivery Service</h2>
        <a href="map.php"><button class="delivery-btn">INSTANT DELIVERY</button></a>
        <a href="nationwide_delivery.php"><button class="delivery-btn">NATIONWIDE DELIVERY</button></a>
    </div>
</body>
</html>
