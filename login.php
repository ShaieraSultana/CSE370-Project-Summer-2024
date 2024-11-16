<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM User WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['ID'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: welcome.php");
        exit();
    }

    $sql = "SELECT * FROM DeliveryMan WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $deliveryman = $result->fetch_assoc();
        $_SESSION['deliveryman_id'] = $deliveryman['ID'];
        $_SESSION['deliveryman_name'] = $deliveryman['name'];
        header("Location: deliverymanhome.php");
        exit();
    }

     $sql = "SELECT * FROM Staff WHERE email = '$email' AND password = '$password'";
     $result = $conn->query($sql);
 
     if ($result->num_rows > 0) {
         $staff = $result->fetch_assoc();
         $_SESSION['staff_id'] = $staff['ID'];
         $_SESSION['staff_name'] = $staff['Name'];

         $sql_manager = "SELECT * FROM Manager WHERE ID = '" . $conn->real_escape_string($staff['ID']) . "'";
         $result_manager = $conn->query($sql_manager);
 
         if ($result_manager->num_rows > 0) {
             header("Location: manager.php");
             exit();
         }
 
         $sql_customer_care = "SELECT * FROM customercare WHERE ID = '" . $conn->real_escape_string($staff['ID']) . "'";
         $result_customer_care = $conn->query($sql_customer_care);
 
         if ($result_customer_care->num_rows > 0) {
             header("Location: customercare.php");
             exit();
         }

         header("Location: staff.php");
         exit();
     }
 
    $error = "Invalid email or password.";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
            <?php if (isset($error)): ?>
                <p style="color:red;"><?php echo $error; ?></p>
            <?php endif; ?>
        </form>
        <p><a href="forgot_password.html">Forgot Password?</a></p>
        <p>New user? <a href="signup.php">Sign Up</a></p>
    </div>
</body>
</html>
