<?php
session_start();
include 'Models/UserModel.php';

class LoginController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function handleLogin() {
        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $type = $_POST['type'];

            $user = $this->userModel->getUserByEmailAndType($email, $type);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_type'] = $user['type'];
                
                header("Location: " . ($type === 'restaurant' ? "Views/restaurant/dashboard.php" : "Views/User/dashboard.php"));
                exit();
            } else {
                echo "<p>Invalid credentials.</p>";
            }
        }
    }
}

$loginController = new LoginController();
$loginController->handleLogin();
?>