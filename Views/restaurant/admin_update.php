<?php
session_start();
define('BASE_PATH', dirname(__DIR__, 2)); 
require_once BASE_PATH . '/Config/db.php';
require_once BASE_PATH . '/Controllers/FoodController.php';

// Redirect if the user is not a restaurant
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'restaurant') {
    header('Location: ../login.php');
    exit();
}

// Initialize database connection
$db = new Database();
$conn = $db->getConnection();

// Initialize FoodController
$foodController = new FoodController($conn);

$message = [];

// Handle delete action
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if ($foodController->deleteFood($id)) {
        $message[] = "Food item deleted successfully!";
        header('Location: dashboard.php');
    } else {
        $message[] = "Failed to delete food item.";
    }
}

// Handle edit action
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $food = $foodController->getFoodDetails($id);
    if (!$food) {
        die("Error: Food not found.");
    }
}

// Handle form submission
if (isset($_POST['add_food'])) {
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $target = BASE_PATH . '../Public/uploaded_img/' . basename($image);

    if ($price === false || $price <= 0) {
        $message[] = "Invalid price.";
    } elseif (move_uploaded_file($image_tmp, $target)) {
        if ($foodController->updateFood($id, $name, $description, $price, $image)) {
            header('Location: dashboard.php');
            exit();
        } else {
            $message[] = "Failed to update product. Please try again!";
        }
    } else {
        $message[] = "Failed to upload image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Public/css/style.css">
</head>
<body>
    
    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '<span class="message">' . $msg . '</span>';
        }
    }
    ?>

    <div class="container">
        <div class="admin-product-form-container centered">
            <?php if (isset($food)) { ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <h3 class="title">Update the product</h3>
                    <input type="text" class="box" name="name" value="<?php echo htmlspecialchars($food['name']); ?>" placeholder="Food Name" required><br>
                    <textarea class="box" name="description" placeholder="Description" required><?php echo htmlspecialchars($food['description']); ?></textarea><br><br>
                    <input type="number" class="box" name="price" value="<?php echo htmlspecialchars($food['price']); ?>" placeholder="Price" required><br><br>
                    <input type="file" class="box" accept="image/png, image/jpeg, image/jpg" name="image" required><br><br>
                    <input type="submit" value="Update Food" name="add_food"><br><br>
                    <a href="dashboard.php" class="btn">Go Back!</a>
                </form>
            <?php } ?>
        </div>
    </div>
</body>
</html>