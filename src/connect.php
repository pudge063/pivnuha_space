<?php
$db_host = getenv("DB_HOST");
$db_user = getenv("MYSQL_USER");
$db_password = getenv("MYSQL_PASSWORD");
$db_name = 'db_test';

$conn = new mysqli($db_host, $db_user, $db_password, $db_name);
if ($conn->connect_error) {
    die("Ошибка: " . $conn->connect_error);
}
