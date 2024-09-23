<?php
session_start();

require_once __DIR__ . "/validator.php";
require_once __DIR__ . "/connect.php";

if (!empty($_POST)) {
    $username = $_POST["username"];
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordConfirm = $_POST["passwordConfirm"];
}

$userExist = isExist('username', $username, $conn);
$phoneExist = isExist('phone', $phone, $conn);
$emailExist = isExist('email', $email, $conn);

if (isExistUser($username, $conn)) {
    $errors[] = isExistUser($username, $conn);
}

if (isExist('phone', $phone, $conn)) {
    $errors[] = "Этот номер телефона уже зарегистрирован.";
}

if (isExist('email', $email, $conn)) {
    $errors[] = "Этот email уже зарегистрирован.";
}

if ($password !== $passwordConfirm) {
    $errors[] = "Пароли не совпадают.";
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header("Location: ../register.php");
    exit();
} else {
    $sql = "INSERT INTO users (username, name, phone, email, password, reg_date) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $username, $name, $phone, $email, $password);
    $stmt->execute();
    $stmt->close();

    header("Location: ../login.php");
}
