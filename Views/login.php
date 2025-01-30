<?php
    require_once '../Config/db.php';
    include '../Controllers/AuthController.php';

    if (isset($_POST['login'])) {
        $db = new Database();
        $conn = $db->getConnection(); 

        $authController = new AuthController($conn);
        $message = $authController->login($_POST['email'], $_POST['password'], $_POST['type']);
        echo "<p>$message</p>";
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<style>
        /* Body Styling */
        body {
            background-image: url('loginbackground.jpg'); /* Update path if needed */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        /* Login Form Container */
        .login-container {
            background: rgba(30, 144, 255, 0.95); /* DodgerBlue background */
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 350px;
        }

        /* Form Heading */
        h1 {
            color: white;
            font-size: 28px;
            margin-bottom: 20px;
        }

        /* Input Fields */
        input, select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            display: block;
            background: white;
            color: #333;
        }

        /* Login Button */
        .login-btn {
            background: white;
            color: dodgerblue;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s ease, color 0.3s ease;
        }

        .login-btn:hover {
            background: #1e90ff;
            color: white;
        }

        /* Message Styling */
        .message {
            margin-top: 15px;
            font-size: 14px;
            color: #fff;
        }
    </style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../Public/css/style.css">
</head>
<body>
    <h1>Login</h1>
    <form action="login.php" method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <label for="type">Sign in as:</label>
        <select name="type" required>
            <option value="user">User</option>
            <option value="restaurant">Restaurant</option>
        </select>
        <input type="submit" name="login" value="Login">
    </form>

    
</body>
</html>
