<?php
require_once __DIR__ . '../../../model/connect.php';
session_start();

if (isset($_SESSION['user_id']) && isset($_FILES['avatar'])) {
    $user_id = $_SESSION['user_id'];
    // Обновлённый путь к директории
    $target_dir = __DIR__ . '../../assets/static/uploads/' . $user_id . '/';

    // Создание директории, если она не существует
    if (!is_dir($target_dir)) {
        if (!mkdir($target_dir, 0755, true) && !is_dir($target_dir)) {
            die("Не удалось создать директорию: $target_dir");
        }
    }

    $ava = "/assets/static/uploads/$user_id/" . basename($_FILES["avatar"]["name"]);
    $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $errors = [];

    $check = getimagesize($_FILES["avatar"]["tmp_name"]);
    if ($check === false) {
        $errors[] = "Файл не является изображением.";
        $uploadOk = 0;
    }

    if (!is_writable($target_dir)) {
        $errors[] = "Директория не доступна для записи: $target_dir";
        $uploadOk = 0; // Добавляем эту строку, чтобы установить $uploadOk в 0
    }

    if (file_exists($target_file)) {
        $errors[] = "Извините, файл уже существует.";
        $uploadOk = 0;
    }

    if ($_FILES["avatar"]["size"] > 500000) {
        $errors[] = "Извините, файл слишком большой.";
        $uploadOk = 0;
    }

    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        $errors[] = "Извините, только JPG, JPEG, PNG и GIF файлы разрешены.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        $errors[] = "Извините, ваш файл не был загружен.";
    } else {
        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
            $sql = "UPDATE users SET avatar = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $ava, $user_id);
            $stmt->execute();
            $stmt->close();
        } else {
            $errors[] = "Ошибка при загрузке файла.";
        }
    }

    mysqli_close($conn);

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
    }

    header("Location: ../profile.php");
    exit;
}
