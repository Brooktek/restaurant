<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
<<<<<<< Updated upstream
    <link rel="stylesheet" href="../public/css/style.css">

    <style>
        /* Body Background Styling */
        body {
            background-image: url('background.jpg'); /* Update path if needed */
=======
    <link rel="stylesheet" href="css/style.css">
    
    <style>
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        
        body {
            background-image: url('background.jpg');
>>>>>>> Stashed changes
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
<<<<<<< Updated upstream
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

        /* Message Styling */
        .message {
            margin-top: 15px;
            font-size: 14px;
            color: #d9534f;
=======
        }

        
        .form-container {
            background-color: rgba(255, 255, 255, 0.15); /* Light semi-transparent white */
            padding: 30px;
            border-radius: 12px;
            width: 350px; /* Adjust width */
            text-align: center;
            backdrop-filter: blur(10px); /* Adds a nice glass effect */
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2); /* Soft shadow effect */
        }

        /* Form Title */
        .form-container h1 {
            font-size: 32px;
            color: white;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* Input Fields */
        .form-container input, 
        .form-container select {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: none;
            border-radius: 8px;
            font-size: 16px;
        }

        /* Input Focus */
        .form-container input:focus, 
        .form-container select:focus {
            outline: 2px solid orange;
        }

        /* Sign-Up Button */
        .form-container input[type="submit"] {
            background-color: orange;
            color: white;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease-in-out;
        }

        /* Button Hover Effect */
        .form-container input[type="submit"]:hover {
            background-color: darkorange;
        }

        /* Label Styling */
        .form-container label {
            font-size: 16px;
            color: white;
            font-weight: bold;
            display: block;
            margin-top: 10px;
>>>>>>> Stashed changes
        }
    </style>
</head>
<body>
<<<<<<< Updated upstream

    <!-- Signup Form Container -->
    <div class="signup-container">
        <h1>Create Your Account</h1>
        <form action="" method="post">
=======
    <div class="form-container">
        <h1>Sign Up</h1>
        <form action="signup.php" method="post">
>>>>>>> Stashed changes
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Create Password" required>
            
            <label for="type">Sign up as:</label>
            <select name="type" required>
                <option value="user">User</option>
                <option value="restaurant">Restaurant</option>
            </select>
<<<<<<< Updated upstream

            <button type="submit" name="signup" class="signup-btn">Sign Up</button>
        </form>

        <!-- Display Success/Error Messages -->
        <?php
        include '../Config/db.php';
        include '../Controllers/AuthController.php';

        if (isset($_POST['signup'])) {
            $authController = new AuthController($conn);
            $message = $authController->signup($_POST['name'], $_POST['email'], $_POST['password'], $_POST['type']);
            echo "<p class='message'>$message</p>";
        }
        ?>
    </div>

=======
            
            <input type="submit" name="signup" value="Sign Up">
        </form>
    </div>
>>>>>>> Stashed changes
</body>
</html>

