<?php
$conn = mysqli_connect('localhost', 'root', '', 'food_ordering');
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
