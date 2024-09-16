<?php

require_once __DIR__ . '/../model/connect.php';
require_once __DIR__ . '/../get_ip.php';

if (isset($_POST['name']) && isset($_POST['beer'])) {
    // $conn = mysqli_connect("db", "admin", "123", "db_test");
    mysqli_set_charset($conn, "utf8");

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $beer = mysqli_real_escape_string($conn, $_POST['beer']);
    $ip = mysqli_real_escape_string($conn, getIp());

    if (mysqli_connect_errno()) {
        echo "провал" . mysqli_connect_error();
    }
    $query1 = "INSERT INTO test1 (name, beer, ip_address) VALUES ('$name', '$beer', '$ip');";
    $result1 = mysqli_query($conn, $query1);

    // if ($result1 = 'true') {
    //     echo "Информация занесена в базу данных";
    // } else {
    //     echo "Информация не занесена в базу данных";
    // }
    mysqli_close($conn);
}

header("Location: ../");
exit();