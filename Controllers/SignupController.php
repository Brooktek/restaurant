<?php
require_once 'Models/UserModel.php';

class SignupController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function handleSignup($postData) {
        if (isset($postData['signup'])) {
            $name = htmlspecialchars($postData['name']);
            $email = htmlspecialchars($postData['email']);
            $password = password_hash($postData['password'], PASSWORD_BCRYPT);
            $type = htmlspecialchars($postData['type']);

            $result = $this->userModel->createUser($name, $email, $password, $type);

            if ($result) {
                return "Account created successfully! <a href='login.php'>Login here</a>";
            } else {
                return "Error: Could not create account.";
            }
        }

        return null;
    }
}
$postData = $_POST;

$signupController = new SignupController();
$message = $signupController ->handleSignup($postData);

if ($message) {
    echo $message; 
}

?>
