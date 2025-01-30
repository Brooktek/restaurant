<?php
class FoodModel extends Database {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
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
        public function updateFood($id, $name, $description, $price, $image) {
            $stmt = $this->conn->prepare("UPDATE foods SET name=?, description=?, price=?, image=? WHERE id=?");
            $stmt->bind_param("sssii", $name, $description, $price, $image, $id);
            return $stmt->execute();
        }
    
        public function deleteFood($id) {
            $delete_orders = "DELETE FROM orders WHERE food_id = '$id'";
            mysqli_query($this->conn, $delete_orders);
    
            $stmt = $this->conn->prepare("DELETE FROM foods WHERE id = ?");
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
}

$restaurantController = new RestaurantController();

if (isset($_POST['add_food'])) {
    $success = $restaurantController->handleAddFood($_POST, $_FILES, $_SESSION['user_id']);
    if ($success) {
        echo "<p>Food item added successfully!</p>";
    } else {
        echo "<p>Error: Could not add food item.</p>";
    }
}

