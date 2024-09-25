<?php
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../captcha.php';

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

    public function validate($value, $field, $user_id)
    {
        $result = $this->userModel->isExists($value, $field, $user_id);
        return $result;
    }

    public function registerUser($username, $name, $phone, $email, $password)
    {
        $this->userModel->create_user($username, $name, $phone, $email, $password);
    }

    public function updateUser($user_id, $updated_fields)
    {
        $this->userModel->update_user($user_id, $updated_fields);
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

        $user_id = NULL;

        if (!empty($_POST)) {
            $username = $_POST['username'];
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $passwordConfirm = $_POST['passwordConfirm'];
        }

        $existPhone = $userController->validate($phone, 'phone', $user_id);
        if ($existPhone === false) {
            $errors[] = 'Телефон уже привязан к другому аккаунту.';
            header('Location: ../views/auth/register.php');
            $_SESSION['errors'] = $errors;
            exit();
        }

        $exitstMail = $userController->validate($email, 'email', $user_id);
        if (isset($existMail) && $existMail === false) {
            $errors[] = 'Почта уже привязана к другому аккаунту.';
            $_SESSION['errors'] = $errors;
            header('Location: ../views/auth/register.php');
            exit();
        }

        $userController->registerUser($username, $name, $phone, $email, $password);

        header('Location: ../views/auth/login.php');
    } elseif ($action === 'edit') {

        if (!isset($_SESSION['user_id'])) {
            header("Location: ../../views/auth/login.php");
            exit();
        }

        $new_name = isset($_POST['name']) ? trim($_POST['name']) : null;
        $new_email = isset($_POST['email']) ? trim($_POST['email']) : null;
        $new_password = isset($_POST['password']) ? trim($_POST['password']) : null;
        $new_phone = isset($_POST['phone']) ? trim($_POST['phone']) : null;
        $new_password = isset($_POST['password']) ? $_POST['password'] : null;


        $user_id = $_SESSION['user_id'];
        $updated_fields = [];
        $errors = [];

        $current_user = $userController->getUser($user_id);

        if (!empty($new_name)) {
            $updated_fields['name'] = $new_name;
        }

        $res = $userController->validate($new_email, 'email', $user_id);

        if ($res == false) {
            $errors[] = "Email уже используется другим пользователем.";
            $_SESSION['errors'] = $errors;
            header('Location: ../../views/users/profile.php');
            exit();
        } else {
            if (!empty($new_email)) {
                $updated_fields['email'] = $new_email;
            }
        }

        $res = $userController->validate($new_phone, 'phone', $user_id);

        if ($res === false) {
            $errors[] = "Телефон уже используется другим пользователем.";
            $_SESSION['errors'] = $errors;
            header('Location: ../../views/users/profile.php');
            exit();
        } else {
            if (!empty($new_phone)) {
                $updated_fields['phone'] = $new_phone;
            }
        }

        if (!empty($new_password)) {
            $updated_fields['password'] = $new_password;
        }

        if (empty($errors) && !empty($updated_fields)) {
            $userController->updateUser($user_id, $updated_fields);
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
        }

        header('Location: ../views/users/profile.php');
        exit();
    }
}
