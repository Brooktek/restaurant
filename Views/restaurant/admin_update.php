<?php
session_start();
define('BASE_PATH', dirname(__DIR__, 2)); 
require_once BASE_PATH . '/Config/db.php';
require_once BASE_PATH . '/Controllers/FoodController.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'restaurant') {
    header('Location: ../login.php');
    exit();
}

$foodController = new FoodController($conn);
$message = [];

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $message[] = $foodController->deleteFood($id);
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $food = $foodController->getFoodDetails($id);
    if (!$food) {
        die("Error: Food not found.");
    }
} else {
    die("Error: No product ID provided to edit.");
}



if (isset($_POST['add_food'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $target = "../uploaded_img/" . basename($image);

    if (empty($name) || empty($price) || empty($description) || empty($image)) {
        $message[] = 'Please fill out all fields!';
    } else {
        if ($foodController->editFood($id, $name, $description, $price, $image)) {
            move_uploaded_file($image_tmp, $target);
            header('Location: dashboard.php');
            exit();
        } else {
            $message[] = 'Failed to update product. Please try again!';
        }
    }
}
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
if (isset($message)) {
    foreach ($message as $message) {
        echo '<span class="message">' . $message . '</span>';
    }
}
?>

<div class="container">
    <div class="admin-product-form-container centered">
        <?php if (isset($foodDetails)) { ?>
            <form action="" method="post" enctype="multipart/form-data">
                <h3 class="title">Update the product</h3>
                <input type="text" class="box" name="name" value="<?php echo htmlspecialchars($foodDetails['name']); ?>" placeholder="Food Name" required>
                <textarea class="box" name="description" placeholder="Description" required><?php echo htmlspecialchars($foodDetails['description']); ?></textarea>
                <input type="number" class="box" name="price" value="<?php echo htmlspecialchars($foodDetails['price']); ?>" placeholder="Price" required>
                <input type="file" class="box" accept="image/png, image/jpeg, image/jpg" name="image" required>
                <input type="submit" value="Update Food" name="add_food">
                <a href="dashboard.php" class="btn">Go Back!</a>
            </form>
        <?php } ?>
    </div>
</div>

</body>
</html>
