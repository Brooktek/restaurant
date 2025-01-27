<?php
session_start();
@include '../includes/db.php';

if ($_SESSION['user_type'] !== 'restaurant') {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST['add_food'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $target = "../uploaded_img/" . basename($image);

    move_uploaded_file($image_tmp, $target);

    $restaurant_id = $_SESSION['user_id'];
    $query = "INSERT INTO foods (restaurant_id, name, description, price, image) 
              VALUES ('$restaurant_id', '$name', '$description', '$price', '$image')";
    mysqli_query($conn, $query);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Restaurant Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Restaurant Dashboard</h1>
    <form action="dashboard.php" method="post" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Food Name" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="number" name="price" placeholder="Price" required>
        <input type="file" accept="image/png, image/jpeg, image/jpg" name="image" required>
        <input type="submit" name="add_food" value="Add Food">
    </form>

    <?php   $select = mysqli_query($conn, "SELECT * FROM foods");   ?>

    <div class="product-display">
      <table class="product-display-table">
         <thead>
         <tr>
            <th> product image </th>
            <th> product name </th>
            <th> Product Description</th>
            <th> product price </th>
            <th>action</th>
         </tr>
         </thead>
         <?php while($row = mysqli_fetch_assoc($select)){ ?>
         <tr>
            <td><img src="../uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td>$<?php echo $row['price']; ?>/-</td>
            <td>
                <a href="admin_update.php?edit=<?php echo $row['id']; ?>" class="btn">Edit</a>
                <a href="admin_update.php?delete=<?php echo $row['id']; ?>" class="btn">Delete</a>
            </td>
         </tr>
      <?php } ?>
      </table>
   </div>
    
</body>
</html>
