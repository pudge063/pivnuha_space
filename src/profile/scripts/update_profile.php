<?php
session_start();
require '../../model/connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/registration.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$updated_fields = [];
$errors = [];

// Получаем текущие данные пользователя
$query = "SELECT name, email, phone, avatar FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$current_user = $result->fetch_assoc();

// Получаем данные из формы с проверкой существования
$new_name = isset($_POST['name']) ? trim($_POST['name']) : null;
$new_email = isset($_POST['email']) ? trim($_POST['email']) : null;
$new_password = isset($_POST['password']) ? trim($_POST['password']) : null;
$new_phone = isset($_POST['phone']) ? trim($_POST['phone']) : null;
$new_avatar = isset($_FILES['avatar']) ? $_FILES['avatar'] : null;

// Проверка на дубликат email
if ($new_email && $new_email !== $current_user['email']) {
    $email_check_query = "SELECT id FROM users WHERE email = ? AND id != ?";
    $stmt = $conn->prepare($email_check_query);
    $stmt->bind_param('si', $new_email, $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $errors[] = "Email уже используется другим пользователем.";
    } else {
        $updated_fields['email'] = $new_email;
    }
}

// Проверка на дубликат телефона
if ($new_phone && $new_phone !== $current_user['phone']) {
    $phone_check_query = "SELECT id FROM users WHERE phone = ? AND id != ?";
    $stmt = $conn->prepare($phone_check_query);
    $stmt->bind_param('si', $new_phone, $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $errors[] = "Телефон уже используется другим пользователем.";
    } else {
        $updated_fields['phone'] = $new_phone;
    }
}

// Проверка пароля
if ($new_password) {
    // $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    // $updated_fields['password'] = $hashed_password;

    $updated_fields['password'] = $new_password; // TODO: Хэширование пароля
}

// Проверка изменения имени
if ($new_name && $new_name !== $current_user['name']) {
    $updated_fields['name'] = $new_name;
}

// Обработка аватара
if ($new_avatar && $new_avatar['size'] > 0) {
    $target_dir = "../uploads/avatars/";
    $target_file = $target_dir . basename($new_avatar["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Проверка, является ли файл изображением
    $check = getimagesize($new_avatar["tmp_name"]);
    if ($check === false) {
        $errors[] = "Файл не является изображением.";
    }

    // Разрешённые форматы изображений
    $allowed_formats = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowed_formats)) {
        $errors[] = "Допустимы только форматы JPG, JPEG, PNG и GIF.";
    }

    // Сохранение аватара
    if (empty($errors)) {
        if (move_uploaded_file($new_avatar["tmp_name"], $target_file)) {
            $updated_fields['avatar'] = $target_file;
        } else {
            $errors[] = "Ошибка при загрузке аватара.";
        }
    }
}

// Если нет ошибок и есть данные для обновления
if (empty($errors) && !empty($updated_fields)) {
    $sql = "UPDATE users SET ";
    $params = [];
    $types = "";

    foreach ($updated_fields as $field => $value) {
        $sql .= "$field = ?, ";
        $params[] = $value;

        if ($field === 'email' || $field === 'name' || $field === 'avatar') {
            $types .= 's'; // string
        } elseif ($field === 'password') {
            $types .= 's'; // string (хэш пароля)
        } elseif ($field === 'phone') {
            $types .= 's'; // string (телефон)
        }
    }

    $sql = rtrim($sql, ', ');
    $sql .= " WHERE id = ?";
    $params[] = $user_id;
    $types .= 'i'; // integer для id

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        // echo "<p style='color:green;'>Профиль успешно обновлён.</p>";
    } else {
        $errors[] = "Ошибка при обновлении профиля: " . $conn->error;
    }
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
}

header('Location: ../profile.php');
exit();
