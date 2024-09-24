<?php require_once __DIR__ . '/../connect.php';

class User
{
    private $conn;

    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;
    }

    public function get_user($user_id)
    {
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        return $user;
    }

    public function update_user($user_id, $updated_fields)
    {
        $sql = "UPDATE users SET ";
        $params = [];
        $types = "";

        foreach ($updated_fields as $field => $value) {
            $sql .= "$field = ?, ";
            $params[] = $value;

            if ($field === 'email' || $field === 'name' || $field === 'avatar') {
                $types .= 's';
            } elseif ($field === 'password') {
                $types .= 's';
            } elseif ($field === 'phone') {
                $types .= 's';
            }
        }

        $sql = rtrim($sql, ', ');
        $sql .= " WHERE id = ?";
        $params[] = $user_id;
        $types .= 'i';

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}



$dbConnection = $conn;
$userController = new UserController($dbConnection);
