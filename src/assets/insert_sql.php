<?php

require_once __DIR__ . '/../model/connect.php';
require_once __DIR__ . '/../assets/helpers/get_ip.php';

$secretKey = '6LdV-kUqAAAAAJvH5Ptw8hxfvp0wRtCcXcCGSy7g';

if (!empty($_POST['g-recaptcha-response'])) {

    // Google reCAPTCHA verification API Request 
    $api_url = 'https://www.google.com/recaptcha/api/siteverify';
    $resq_data = array(
        'secret' => $secretKey,
        'response' => $_POST['g-recaptcha-response'],
        'remoteip' => $_SERVER['REMOTE_ADDR']
    );

    $curlConfig = array(
        CURLOPT_URL => $api_url,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => $resq_data,
        CURLOPT_SSL_VERIFYPEER => false
    );

    $ch = curl_init();
    curl_setopt_array($ch, $curlConfig);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        $api_error = curl_error($ch);
    }
    curl_close($ch);

    // Decode JSON data of API response in array 
    $responseData = json_decode($response);

    if(!empty($responseData) && $responseData->success) {
        $valid_captcha = 'true';
    }
}

if (isset($_POST['name']) && isset($_POST['beer']) && $valid_captcha == 'true') {
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

    mysqli_close($conn);
}

exit();
