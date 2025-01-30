<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <h1>Sign Up</h1>
    <form action="signup.php" method="post">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <label for="type">Sign up as:</label>
        <select name="type" required>
            <option value="user">User</option>
            <option value="restaurant">Restaurant</option>
        </select>
        <input type="submit" name="signup" value="Sign Up">
    </form>

    <?php
    include '../Config/db.php';
    include  '../Controllers/AuthController.php';

    if (isset($_POST['signup'])) {
        $authController = new AuthController($conn);
        $message = $authController->signup($_POST['name'], $_POST['email'], $_POST['password'], $_POST['type']);
        echo "<p>$message</p>";
    }
    ?>
</body>
</html>
