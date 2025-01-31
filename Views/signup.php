<?php
    require_once '../Config/db.php';
    include '../Controllers/AuthController.php';

    if (isset($_POST['signup'])) {
        $db = new Database();
        $conn = $db->getConnection(); 

        $authController = new AuthController($conn);
        $message = $authController->signup($_POST['name'], $_POST['email'], $_POST['password'], $_POST['type']);
        echo "<p>$message</p>";
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../Public/css/style.css">
</head>
<body>
    <div class="signup-container">
        <h1>Create Your Account</h1>
        <form action="signup.php" method="post">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Create Password" required>
            <label for="type">Sign up as:</label>
            <select name="type" required>
                <option value="user">User</option>
                <option value="restaurant">Restaurant</option>
            </select>
            <button type="submit" name="signup" class="signup-btn">Sign Up</button>
            <p>Already have an account? <a href="login.php">Log in here</a></p>
        </form>
    </div>
</body>
</html>