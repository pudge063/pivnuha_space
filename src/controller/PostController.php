<?php
require_once __DIR__ . '/../model/Post.php';

class PostController
{
    private $postModel;

    public function __construct($dbConnection)
    {
        $this->postModel = new Post($dbConnection);
    }

    public function index()
    {
        return $this->postModel->readPosts();
    }

    public function get_post_by_id($post_id)
    {
        $post = $this->postModel->readPost($post_id);
        return $post;
    }

    public function delete($post_id, $user_id)
    {
        return $this->postModel->deletePost($post_id, $user_id);
    }

    public function handleDeletePost()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            die('Необходимо авторизоваться.');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post_id = $_POST['post_id'];
            $user_id = $_SESSION['user_id'];
            $is_admin = $_SESSION['is_admin'];

            $post = $this->get_post_by_id($post_id);

            if ($post['user_id'] == $user_id || $is_admin === 1) {
                $res = $this->delete($post_id, $user_id);
            }

            if (!isset($res)) {
                $errors[] = "Не удалось удалить пост.";
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
            }
            header('Location: ../index.php');
            exit;
        }
    }

    public function create()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            $errors[] = 'Для отправки нужно авторизоваться.';
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'];
            $post_content = $_POST['post_content'];

            if ($this->postModel->createPost($user_id, $post_content)) {
            } else {
                $errors[] = 'Ошибка при добавлении поста.';
            }
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
        }

        header('Location: ../index.php');
        exit();
    }



    public function read_table()
    {
        return $this->postModel->readTable();
    }
}


$dbConnection = $conn;
$postController = new PostController($dbConnection);


// $dbConnection = $conn;
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action === 'delete') {

        $postController->handleDeletePost();
    }

    //

    elseif ($action === 'create') {

        $postController->create();
    }
}
