<?php
require_once __DIR__ . '/../model/User.php';

class UserController
{
    private $userModel;

    public function __construct($dbConnection)
    {
        $this->userModel = new User($dbConnection);
    }

    public function getUser($user_id) {
        $result = $this->userModel->get_user($user_id);
        return $result;
    }

    public function registerUser() {
        
    }
}


$dbConnection = $conn;
$userController = new UserController($dbConnection);