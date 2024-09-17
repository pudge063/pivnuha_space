<?php

function validate_capthca()
{

    if (!empty($_POST['g-recaptcha-response'])) {
        $secretKey = '6LdV-kUqAAAAAJvH5Ptw8hxfvp0wRtCcXcCGSy7g';

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

        if (!empty($responseData) && $responseData->success) {
            $valid_captcha = 'true';
        } else {
            $valid_captcha = 'false';
        }
    }

    return $valid_captcha;
}
