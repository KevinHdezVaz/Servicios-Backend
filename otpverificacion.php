<?php
require 'vendor/autoload.php';

use Twilio\Rest\Client;

$accountSid = 'ACa12cc3b2e0a4d17f6c0712e489d726cb';
$authToken = 'c3fd4cd5f337b9333f666f371aeacff5';

$recipientNumber = $_POST['recipientNumber'];

$otp = mt_rand(100000, 999999);

$message = "Tu código de verificación es: $otp";

$client = new Client($accountSid, $authToken);

try {
    $message = $client->messages->create(
        $recipientNumber,
        [
            'from' => '12255353616',
            'body' => $message
        ]
    );

    // Devuelve el código OTP en la respuesta JSON
    $response = array(
        'status' => 'success',
        'otp' => $otp
    );

    header('Content-Type: application/json');
    echo json_encode($response);
} catch (Exception $e) {
    // Manejo de errores
    $response = array(
        'status' => 'error',
        'message' => 'Error al enviar el mensaje: ' . $e->getMessage()
    );

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
