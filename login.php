<?php
session_start();
require_once 'includes/db.php';  // Include the database connection

// Initialize the Database class to get the connection
$db = new Database();
$conn = $db->getConnection();  // Get the connection object
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
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

    <?php
    if (isset($_POST['login'])) {
        // Get the form inputs
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $type = $_POST['type'];

<<<<<<< HEAD
<<<<<<< HEAD
        // Use prepared statement to avoid SQL injection
        $query = "SELECT * FROM users WHERE email = ? AND type = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ss', $email, $type);  // 'ss' means two strings
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
=======
=======
>>>>>>> parent of b2e7ceb (updated)
        $query = "SELECT * FROM users WHERE email='$email' AND type='$type'";
        $result = mysqli_query($conn, $query);
>>>>>>> parent of b2e7ceb (updated)

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
<<<<<<< HEAD
<<<<<<< HEAD
                // Set session variables for user login
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_type'] = $user['type'];
                
                // Redirect user based on type
=======
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_type'] = $user['type'];
>>>>>>> parent of b2e7ceb (updated)
=======
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_type'] = $user['type'];
>>>>>>> parent of b2e7ceb (updated)
                header("Location: " . ($type === 'restaurant' ? "restaurant/dashboard.php" : "user/dashboard.php"));
                exit();  // Always call exit after a header redirection
            } else {
                echo "<p>Invalid password.</p>";
            }
        } else {
            echo "<p>No account found for this email.</p>";
        }
    }
    ?>
</body>
</html>
//hi hello
