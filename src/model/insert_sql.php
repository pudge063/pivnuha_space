<?php

require_once __DIR__ . '/connect.php';
require_once __DIR__ . '/../assets/helpers/get_ip.php';
require_once __DIR__ . '/../assets/helpers/captcha.php';

$valid_captcha = validate_capthca();

if (isset($_POST['name']) && isset($_POST['beer']) && $valid_captcha == 'true') {
    mysqli_set_charset($conn, "utf8");

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $beer = mysqli_real_escape_string($conn, $_POST['beer']);
    $ip = mysqli_real_escape_string($conn, getIp());
    $user_agent = mysqli_real_escape_string($conn, $_SERVER['HTTP_USER_AGENT']);

    if (mysqli_connect_errno()) {
        echo "провал" . mysqli_connect_error();
    }

    $query1 = "INSERT INTO test1 (name, beer, ip_address, user_agent) VALUES ('$name', '$beer', '$ip', '$user_agent');";
    $result1 = mysqli_query($conn, $query1);

    mysqli_close($conn);
}

exit();
