<?php
class FoodModel extends Database {
    private $conn;

    public function __construct() {
        parent::__construct(); 
        $this->conn = $this->getConnection();

        if (!$this->conn) {
            die("Failed to establish a database connection.");
        }
    }

    public function addFood($restaurantId, $name, $description, $price, $image) {
        $query = "INSERT INTO foods (restaurant_id, name, description, price, image) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("issds", $restaurantId, $name, $description, $price, $image);
        return $stmt->execute();
    }

    public function getFoodsByRestaurant($restaurantId) {
        $query = "SELECT * FROM foods WHERE restaurant_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $restaurantId);
        $stmt->execute();
        return $stmt->get_result();
    }
        // Update food information
        public function updateFood($id, $name, $description, $price, $image) {
            $stmt = $this->conn->prepare("UPDATE foods SET name=?, description=?, price=?, image=? WHERE id=?");
            $stmt->bind_param("sssii", $name, $description, $price, $image, $id);
            return $stmt->execute();
        }
    
        // Delete food and related orders
        public function deleteFood($id) {
            // Delete related orders
            $delete_orders = "DELETE FROM orders WHERE food_id = '$id'";
            mysqli_query($this->conn, $delete_orders);
    
            // Delete food
            $stmt = $this->conn->prepare("DELETE FROM foods WHERE id = ?");
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
}
// Initialize the controller
$restaurantController = new RestaurantController();

// Handle Add Food functionality
if (isset($_POST['add_food'])) {
    $success = $restaurantController->handleAddFood($_POST, $_FILES, $_SESSION['user_id']);
    if ($success) {
        echo "<p>Food item added successfully!</p>";
    } else {
        echo "<p>Error: Could not add food item.</p>";
    }
}

