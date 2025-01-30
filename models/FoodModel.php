<?php
class FoodModel extends Database {
    private $conn;

    public function __construct() {
        parent::__construct(); // Call the Database class constructor
        $this->conn = $this->getConnection();

        // Debugging output
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

