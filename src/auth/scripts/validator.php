<?php

require_once __DIR__ . '/connect.php';

function isExist($field, $value, $conn)
{
    $sql = "SELECT * FROM users WHERE $field = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $value);
    $stmt->execute();
    $result = $stmt->get_result();
    $rowsCount = $result->num_rows;
    $stmt->close();

    if ($rowsCount > 0) {
        return "Такой $field уже существует!";
    }
}

function isExistUser($username, $conn)
{
    if (strlen($username) < 3 || strlen($username) > 20) {
        return "Имя пользователя должно быть длиной от 3 до 20 символов!";
    }

    if (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
        return "Имя пользователя может содержать только буквы английского алфавита и цифры!";
    }

    $existError = isExist('username', $username, $conn);
    if ($existError) {
        return $existError;
    }
}
