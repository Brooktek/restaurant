<?php

@include '../includes/db.php';


if (isset($_GET['delete'])) {
   $id = $_GET['delete'];

   // Delete related orders first
   $delete_orders = "DELETE FROM orders WHERE food_id = '$id'";
   mysqli_query($conn, $delete_orders);

   // Then delete the food
   $stmt = $conn->prepare("DELETE FROM foods WHERE id = ?");
   $stmt->bind_param("i", $id);

   if ($stmt->execute()) {
       // Redirect after deletion
       header('Location: dashboard.php');
       exit();
   } else {
       $message[] = 'Failed to delete product. Please try again!';
   }
   $stmt->close();
}

if (isset($_GET['edit'])) {
   $id = $_GET['edit'];
} else {
   die("Error: No product ID provided to edit.");
}

// Edit functionality
if(isset($_POST['add_food'])){
  $name = $_POST['name'];
  $description = $_POST['description'];
  $price = $_POST['price'];
  $image = $_FILES['image']['name'];
  $image_tmp = $_FILES['image']['tmp_name'];
  $target = "../uploaded_img/" . basename($image);

  if (empty($name) || empty($price) || empty($description) || empty($image)) {
   $message[] = 'Please fill out all fields!';
} else {
   $update_data = "UPDATE foods 
                   SET name='$name', description='$description', price='$price', image='$image' 
                   WHERE id='$id'";
   $upload = mysqli_query($conn, $update_data);

   if ($upload) {
       move_uploaded_file($image_tmp, $target);
       header('Location: dashboard.php');
   } else {
       $message[] = 'Failed to update product. Please try again!';
   }
}

};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
   if(isset($message)){
      foreach($message as $message){
         echo '<span class="message">'.$message.'</span>';
      }
   }
?>

<div class="container">
<div class="admin-product-form-container centered">

   <?php
      
      $select = mysqli_query($conn, "SELECT * FROM foods WHERE id = '$id'");
      while($row = mysqli_fetch_assoc($select)){

   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <h3 class="title">update the product</h3>
      <input type="text" class="box" name="name" value="<?php echo $row['name']; ?>" placeholder="Food Name" required>
      <textarea class="box" name="description" placeholder="Description" required><?php echo $row['description']; ?></textarea>
      <input type="number" class="box" name="price" value="<?php echo $row['price']; ?>" placeholder="Price" required>
        <input type="file" class="box" accept="image/png, image/jpeg, image/jpg" name="image" required>
        <input type="submit" value="add food" name="add_food" value="Add Food">
        <a href="dashboard.php" class="btn">go back!</a>

   </form>
   <?php }; ?>   

</div>

</div>

</body>
</html>