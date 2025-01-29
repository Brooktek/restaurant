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
</body>
</html>