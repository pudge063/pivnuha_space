<?php
require_once __DIR__ . '../../../model/connect.php';
session_start();

if (isset($_SESSION['user_id']) && isset($_FILES['avatar'])) {
    $user_id = $_SESSION['user_id'];
    $target_dir = "../../assets/static/uploads/$user_id/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }
    $ava = "/assets/static/uploads/$user_id/" . basename($_FILES["avatar"]["name"]);
    $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["avatar"]["tmp_name"]);
    if ($check === false) {
        $errors[] = "Файл не является изображением.";
        $uploadOk = 0;
    }

    if (file_exists($target_file)) {
        $errors[] = "Извините, файл уже существует.";
        $uploadOk = 0;
    }

    if ($_FILES["avatar"]["size"] > 500000) {
        $errors[] = "Извините, файл слишком большой.";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
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

            // if ($stmt->affected_rows > 0) {
            //     $errors = "Аватар успешно загружен.";
            // } else {
            //     $errors = "Ошибка при обновлении базы данных.";
            // }

            $stmt->close();
        } else {
            $errors = "Ошибка при загрузке файла.";
        }
    }

    mysqli_close($conn);
    
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
    }

    header("Location: ../profile.php");
}
