<?php
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../captcha.php';
// require_once __DIR__ . '/../model/Database.php';
require_once __DIR__ . '/../connect.php';

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

    public function loginUser($username)
    {
        $user = $this->userModel->get_user_by_username($username);
        return $user;
    }

    public function validate($value, $field)
    {
        $result = $this->userModel->isExists($value, $field);
        return $result;
    }

    public function registerUser($username, $name, $phone, $email, $password)
    {
        $this->userModel->create_user($username, $name, $phone, $email, $password);
    }

    public function updateUser() {
        
    }
}

$dbConnection = $conn;
$userController = new UserController($dbConnection);

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if ($action === 'login') {
        $is_valid = validate_capthca();

        if ($is_valid == false || !isset($is_valid)) {
            $errors[] = 'Не пройдена капча.';
            $_SESSION['errors'] = $errors;
            header('Location: ../views/auth/login.php');
            exit();
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
    } elseif ($action === 'logout') {
        $_SESSION = [];
        session_destroy();

        header('Location: ../../');
        exit();
    } elseif ($action === 'register') {
        $is_valid = validate_capthca();
        if ($is_valid == false) {
            $errors[] = 'Не пройдена капча.';
            $_SESSION['errors'] = $errors;
            header('Location: ../views/auth/register.php');
        }

        if (!empty($_POST)) {
            $username = $_POST['username'];
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $passwordConfirm = $_POST['passwordConfirm'];
        }

        $res = $userController->validate($username, 'username');
        if ($res == 'true') {
            $errors[] = 'Имя пользователя занято.';
            header('Location: ../views/auth/register.php');
            $_SESSION['errors'] = $errors;
            exit();
        }

        $res = $userController->validate($phone, 'phone');
        if ($res === 'true') {
            $errors[] = 'Телефон уже привязан к другому аккаунту.';
            header('Location: ../views/auth/register.php');
            $_SESSION['errors'] = $errors;
            exit();
        }

        $res = $userController->validate($email, 'email');
        if ($res == 'true') {
            $errors[] = 'Почта уже привязана к другому аккаунту.';
            $_SESSION['errors'] = $errors;
            header('Location: ../views/auth/register.php');
            exit();
        }

        $userController->registerUser($username, $name, $phone, $email, $password);

        header('Location: ../views/auth/login.php');
    }
}
