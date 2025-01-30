<?php
define('BASE_PATH', dirname(__DIR__));
include BASE_PATH . '/Models/UserModel.php';
require_once BASE_PATH . '/Config/db.php';


class AuthController {
    private $userModel;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->userModel = new UserModel($conn);
    }

    public function login($email, $password, $type) {
        
        $user = $this->userModel->getUserByEmailAndType($email, $type);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id']; 
                $_SESSION['user_type'] = $user['type'];  
                header("Location: " . ($type === 'restaurant' ? "restaurant/dashboard.php" : "user/dashboard.php"));
                exit;
            } else {
                return "Invalid password.";
            }
        } else {
            return "No account found for this email.";
        }
    }

    public function signup($name, $email, $password, $type) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        if ($this->userModel->createUser($name, $email, $hashedPassword, $type)) {
            return "Account created successfully! <a href='login.php'>Login here</a>";
        } else {
            return "Error: Could not create account.";
        }
    }
}

