<?php

function validate_capthca()
{
    $secretKey = getenv("CAPTCHA_PRIVATE_KEY");

    if (!empty($_POST['g-recaptcha-response'])) {


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

        $responseData = json_decode($response);

        if (!empty($responseData) && $responseData->success) {
            $valid_captcha = 'true';
        } else {
            $valid_captcha = 'false';
        }
    }

    return $valid_captcha;
}
