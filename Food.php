<?php
class Food {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db->getConnection();
    }

    // Add food item to the database
    public function addFood($restaurant_id, $name, $description, $price, $image) {
        // Handle file upload
        $target_dir = "../uploaded_img/";
        $image_name = basename($image['name']);
        $target_file = $target_dir . $image_name;
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is a valid image type (PNG, JPG, JPEG)
        if ($image_file_type != "jpg" && $image_file_type != "jpeg" && $image_file_type != "png") {
            return "Only JPG, JPEG, and PNG files are allowed.";
        }

        // Check if file upload is successful
        if (move_uploaded_file($image['tmp_name'], $target_file)) {
            // Successfully uploaded file
            // Insert food into the database
            $query = "INSERT INTO foods (restaurant_id, name, description, price, image) 
                      VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param("issds", $restaurant_id, $name, $description, $price, $image_name);
            
            if ($stmt->execute()) {
                return "Food added successfully.";
            } else {
                return "Error adding food: " . $stmt->error;
            }
        } else {
            return "Error uploading image.";
        }
    }

    // Get all foods by restaurant
    public function getFoodsByRestaurant($restaurant_id) {
        $query = "SELECT * FROM foods WHERE restaurant_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $restaurant_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Fetch all available foods (useful for the user dashboard)
    public function getAvailableFoods() {
        $query = "SELECT foods.*, users.name AS restaurant_name 
                  FROM foods 
                  JOIN users ON foods.restaurant_id = users.id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
