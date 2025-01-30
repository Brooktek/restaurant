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
    <link rel="stylesheet" href="../public/css/style.css">

    <style>
        body {
            background-image: url('background.jpg'); /* Update path if needed */
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

        /* Form Container */
        .signup-container {
            background: rgba(231, 160, 6, 0.37); /* Light background with transparency */
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 350px;
            backdrop-filter: blur(5px);
        }

        /* Form Header */
        h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }

        /* Input Fields */
        input, select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            display: block;
        }

        /* Sign-Up Button */
        .signup-btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .signup-btn:hover {
            background: #0056b3;
        }

        .message {
            margin-top: 15px;
            font-size: 14px;
            color: #d9534f;
        }
    </style>
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
        </form>

    </div>

</body>
</html>

