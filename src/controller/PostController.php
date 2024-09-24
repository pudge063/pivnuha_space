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

            if ($this->delete($post_id, $user_id)) {
                header('Location: ../index.php');
                exit;
            } else {
                echo "Не удалось удалить пост.";
            }
        }
    }

    public function create()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            die('Необходимо авторизоваться.');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'];
            $post_content = $_POST['post_content'];

            if ($this->postModel->createPost($user_id, $post_content)) {
                header('Location: ../index.php');
                exit;
            } else {
                echo "Не удалось удалить пост.";
            }
        }
    }
}


$dbConnection = $conn;
$postController = new PostController($dbConnection);


$dbConnection = $conn;
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action === 'delete') {
        $postController->handleDeletePost();
    } elseif ($action === 'create') {
        $postController->create();
    }
}
