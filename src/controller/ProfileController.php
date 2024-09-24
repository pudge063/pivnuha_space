<?php
require_once __DIR__ . '/../model/User.php';

class UserController
{
    private $userModel;

    public function __construct($dbConnection)
    {
        $this->userModel = new User($dbConnection);
    }

    public function getUser($user_id)
    {
        $result = $this->userModel->get_user($user_id);
        return $result;
    }

    public function registerUser() {}

    public function loginUser($username)
    {
        $user = $this->userModel->get_user_by_username($username);
        return $user;
    }
}


$dbConnection = $conn;
$userController = new UserController($dbConnection);

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action === 'login') {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!empty($_POST)) {
            $username = $_POST["username"];
            $password = $_POST["password"];
        }
        $user = $userController->loginUser($username, $password);

        if ($user && $password == $user["password"]) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['name'] = $user['name'];

            header("Location: ../");
            exit();
        } else {
            $errors[] = "Неверное имя пользователя или пароль.";
            $_SESSION["errors"] = $errors;
            header("Location: ../views/auth/login.php");
        }
    }
}
