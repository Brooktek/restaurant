<?php @include 'includes/db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/style.css">
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
    if (isset($_POST['signup'])) {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $type = $_POST['type'];

        $query = "INSERT INTO users (name, email, password, type) VALUES ('$name', '$email', '$password', '$type')";
        if (mysqli_query($conn, $query)) {
            echo "<p>Account created successfully! <a href='login.php'>Login here</a></p>";
        } else {
            echo "<p>Error: Could not create account.</p>";
        }
    }
    ?>
</body>
</html>
