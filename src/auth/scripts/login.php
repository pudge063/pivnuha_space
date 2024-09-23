<?php
session_start();

require_once __DIR__ . "/validator.php";
require_once __DIR__ . "/connect.php";

if (!empty($_POST)) {
    $username = $_POST["username"];
    $password = $_POST["password"];
}

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    // echo $user["password"];
} else {
    $errors[] = "Неверные данные пользователя!";
}

// if (!empty($errors)) {
//     $_SESSION['errors'] = $errors;
//     header("Location: ../login.php");
//     exit();
// } else {
//     // $sql = "INSERT INTO users (username, phone, email, password, reg_date) VALUES (?, ?, ?, ?, NOW())";
//     // $stmt = $conn->prepare($sql);
//     // $stmt->bind_param("ssss", $username, $phone, $email, $password);
//     // $stmt->execute();
//     // // $result = $stmt->get_result();
//     // // $rowsCount = $result->num_rows;
//     // $stmt->close();

//     header("Location: ../../");
// }

if ($user && $password == $user["password"]) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['name'] = $user['name'];

    header("Location: ../../profile/profile.php");
    exit();
} else {
    $errors[] = "Неверное имя пользователя или пароль.";
    $_SESSION["errors"] = $errors;
    header("Location: ../login.php");
}

$stmt->close();
