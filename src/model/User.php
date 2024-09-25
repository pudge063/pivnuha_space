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

    public function get_user_by_username($identifier)
    {
        $query = "SELECT * FROM users WHERE username = ? OR email = ? OR phone = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('sss', $identifier, $identifier, $identifier);

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

    public function create_user($username, $name, $phone, $email, $password)
    {
        $sql = "INSERT INTO users (username, name, phone, email, password, reg_date) VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssss", $username, $name, $phone, $email, $password);
        $stmt->execute();
    }


    public function isExists($value, $field)
    {
        $sql = "SELECT * FROM users WHERE $field = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $value);
        $stmt->execute();
        $result = $stmt->get_result();
        $rowsCount = $result->num_rows;
        $stmt->close();

        if ($rowsCount > 0) {
            return true;
        }
        return true;
    }
}



$dbConnection = $conn;
$userController = new UserController($dbConnection);
