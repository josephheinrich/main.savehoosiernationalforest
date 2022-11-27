<?php
require_once 'config.php';
$captcha;
  $captcha = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_STRING);
  if(!$captcha){
    echo '
Please check the the captcha form.
';
    exit;
  }
  $secretKey = CAPTCHA_SECRET;
  $ip = $_SERVER['REMOTE_ADDR'];

  // post request to server
  $url = 'https://www.google.com/recaptcha/api/siteverify';
  $data = array('secret' => $secretKey, 'response' => $captcha);

  $options = array(
    'http' => array(
      'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
      'method'  => 'POST',
      'content' => http_build_query($data)
    )
  );
  $context  = stream_context_create($options);
  $response = file_get_contents($url, false, $context);
  $responseKeys = json_decode($response,true);
  header('Content-type: application/json');
  if($responseKeys["success"]) {
    echo json_encode(array('success' => 'true'));
  } else {
    echo json_encode(array('success' => 'false'));
  }
?>