<?php
require_once __DIR__ . '/../connect.php';

class Post
{
    private $conn;

    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;
    }

    public function readPosts()
    {
        $query = "SELECT posts.*, users.avatar, users.name FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.date DESC";
        $result = $this->conn->query($query);
        return $result;
    }

    public function readPost($post_id)
    {
        $query = "SELECT posts.*, users.avatar, users.name FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $post = $result->fetch_assoc();
        return $post;
    }

    // public function deletePost($post_id, $user_id)
    // {
    //     $query = "SELECT * FROM posts WHERE id = ?";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->bind_param("i", $post_id);
    //     $stmt->execute();
    //     $result = $stmt->get_result();

    //     if ($result->num_rows > 0) {
    //         $post = $result->fetch_assoc();

    //         if ($post['user_id'] == $user_id) {
    //             $deleteQuery = "DELETE FROM posts WHERE id = ?";
    //             $deleteStmt = $this->conn->prepare($deleteQuery);
    //             $deleteStmt->bind_param("i", $post_id);
    //             $deleteStmt->execute();

    //             if ($deleteStmt->affected_rows > 0) {
    //                 return true;
    //             }
    //         }
    //     }

    //     return false;
    // }

    public function deletePost($post_id)
    {
        $query = "DELETE FROM posts WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $post_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return true;
        }

        return false;
    }

    public function createPost($user_id, $post_content)
    {
        $query = "INSERT INTO posts (user_id, text) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("is", $user_id, $post_content); // "is" - integer и string
        return $stmt->execute();
    }

    public function readTable()
    {
        $query = "SELECT * FROM test1 ORDER BY create_date DESC LIMIT 30;";
        $result = $this->conn->query($query);
        return $result;
    }
}
