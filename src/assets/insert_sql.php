<?php

require_once __DIR__ . '/../model/connect.php';
require_once __DIR__ . '/../get_ip.php';

if (isset($_POST['name']) && isset($_POST['beer']) && !empty($_POST['g-recaptcha-response'])) {
    // $conn = mysqli_connect("db", "admin", "123", "db_test");
    mysqli_set_charset($conn, "utf8");

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $beer = mysqli_real_escape_string($conn, $_POST['beer']);
    $ip = mysqli_real_escape_string($conn, getIp());
    $user_agent = mysqli_real_escape_string($conn, $_SERVER['HTTP_USER_AGENT']);

    if (mysqli_connect_errno()) {
        echo "провал" . mysqli_connect_error();
    }
    $c = $_POST['g-recaptcha-response'];
    $query1 = "INSERT INTO test1 (name, beer, ip_address, user_agent) VALUES ('$name', '$beer', '$ip', '$user_agent');";
    $result1 = mysqli_query($conn, $query1);

    echo $c;
    mysqli_close($conn);
}

// header("Location: ../");
exit();
