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


    public function loginUser($username, $password)
    {

        $is_valid = validate_capthca();

        if ($is_valid == false || !isset($is_valid)) {
            $errors[] = 'Не пройдена капча.';
            $_SESSION['errors'] = $errors;
            header('Location: ../views/auth/login.php');
            exit();
        }

        $user = $this->userModel->get_user_by_username($username, $password);

        return $user;
    }


    public function validate($value, $field, $user_id)
    {
        $result = $this->userModel->isExists($value, $field, $user_id);
        return $result;
    }


    public function registerUser($username, $name, $phone, $email, $password, $passwordConfirm)
    {

        $user_id = NULL;

        if ($password != $passwordConfirm) {
            $errors[] = 'Не совпадают пароли.';
            // $_SESSION['errors'] = $errors;
            // header('Location: ../views/auth/register.php');
            // exit();
        }

        if (strlen($username) < 4 || strlen($username) > 15 || !preg_match('/^[a-zA-Z]+$/', $username)) {
            $errors[] = "Логин только от 4 до 15 символов. Можно использовать только латиницу.";
            // $_SESSION['errors'] = $errors;
            // header('Location: ../views/auth/register.php');
            // exit();
        }

        if (strlen($phone) < 8 || strlen($phone) > 12 || !preg_match('/^[0-9]+$/', $phone)) {
            $errors[] = "Телефон только от 8 до 12 символов. Можно использовать только цифры.";
            // $_SESSION['errors'] = $errors;
            // header('Location: ../views/auth/register.php');
            // exit();
        }

        $existUsername = $this->validate($username, 'username', $user_id);
        if ($existUsername === 'once') {
            $errors[] = 'Имя пользователя занято.';
            // header('Location: ../views/auth/register.php');
            // $_SESSION['errors'] = $errors;
            // exit();
        }


        $existPhone = $this->validate($phone, 'phone', $user_id);
        if ($existPhone === 'once') {
            $errors[] = 'Телефон уже привязан к другому аккаунту.';
            // header('Location: ../views/auth/register.php');
            // $_SESSION['errors'] = $errors;
            // exit();
        }

        $existMail = $this->validate($email, 'email', $user_id);
        if (isset($existMail) && $existMail === 'once') {
            $errors[] = 'Почта уже привязана к другому аккаунту.';
            // $_SESSION['errors'] = $errors;
            // header('Location: ../views/auth/register.php');
            // exit();
        }

        if (empty($errors)) {
            $this->userModel->create_user($username, $name, $phone, $email, $password);
            header('Location: ../views/auth/login.php');
            exit();
        } else {
            $_SESSION['errors'] = $errors;
            header('Location: ../views/auth/register.php');
            exit();
        }
    }


    public function updateUser($current_user, $fields)
    {
        $new_name = $fields['new_name'];
        $new_email = $fields['email'];
        $new_phone = $fields['phone'];
        $new_password = $fields['password'];

        $user_id = $current_user['id'];

        if (!empty($new_name)) {
            $updated_fields['name'] = $new_name;
        }


        if (!empty($new_email)) {
            $res = $this->validate($new_email, 'email', $user_id);

            if ($res == false) {
                $errors[] = "Email уже используется другим пользователем.";
            } else {
                $updated_fields['email'] = $new_email;
            }
        } else {

            $updated_fields['email'] = $current_user['email'];
        }


        if (!empty($new_phone)) {
            if (strlen($new_phone) < 8 || strlen($new_phone) > 12 || !preg_match('/^[0-9]+$/', $new_phone)) {
                $errors[] = "Телефон только от 8 до 12 символов. Можно использовать только цифры.";
            }


            $res = $this->validate($new_phone, 'phone', $user_id);

            if ($res === false) {
                $errors[] = "Телефон уже используется другим пользователем.";
            } else {
                $updated_fields['phone'] = $new_phone;
            }
        } else {
            $new_phone = $current_user['phone'];
        }


        if (!empty($new_password)) {
            $updated_fields['password'] = $new_password;
        }

        if (empty($errors)) {
            $this->userModel->update_user($user_id, $updated_fields);
        } else {
            $_SESSION['errors'] = $errors;
        }
    }
}

$dbConnection = $conn;
$userController = new UserController($dbConnection);

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // login

    if ($action === 'login') {

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

    // logout

    elseif ($action === 'logout') {
        $_SESSION = [];
        session_destroy();

        header('Location: ../../');
        exit();
    }

    // register

    elseif ($action === 'register') {

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

        $userController->registerUser($username, $name, $phone, $email, $password, $passwordConfirm);

        // header('Location: ../views/auth/login.php');
    }


    /// edit

    elseif ($action === 'edit') {

        if (!isset($_SESSION['user_id'])) {
            header("Location: ../../views/auth/login.php");
            exit();
        }

        $fields['new_name'] = isset($_POST['name']) ? trim($_POST['name']) : null;
        $fields['email'] = isset($_POST['email']) ? trim($_POST['email']) : null;
        $fields['password'] = isset($_POST['password']) ? trim($_POST['password']) : null;
        $fields['phone'] = isset($_POST['phone']) ? trim($_POST['phone']) : null;


        $user_id = $_SESSION['user_id'];
        $updated_fields = [];
        $errors = [];

        $current_user = $userController->getUser($user_id);

        $userController->updateUser($current_user, $fields);

        /////// удалить потом

        // if (!empty($new_name)) {
        //     $updated_fields['name'] = $new_name;
        // }

        // $res = $userController->validate($new_email, 'email', $user_id);

        // if ($res == false) {
        //     $errors[] = "Email уже используется другим пользователем.";
        //     $_SESSION['errors'] = $errors;
        //     header('Location: ../../views/users/profile.php');
        //     exit();
        // } else {
        //     if (!empty($new_email)) {
        //         $updated_fields['email'] = $new_email;
        //     }
        // }

        // $res = $userController->validate($new_phone, 'phone', $user_id);

        // if ($res === false) {
        //     $errors[] = "Телефон уже используется другим пользователем.";
        //     $_SESSION['errors'] = $errors;
        //     header('Location: ../../views/users/profile.php');
        //     exit();
        // } else {
        //     if (!empty($new_phone)) {
        //         $updated_fields['phone'] = $new_phone;
        //     }
        // }

        // if (!empty($new_password)) {
        //     $updated_fields['password'] = $new_password;
        // }

        // if (empty($errors) && !empty($updated_fields)) {
        //     $userController->updateUser($user_id, $updated_fields);
        // }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
        }

        header('Location: ../views/users/profile.php');
        exit();
    }
}
