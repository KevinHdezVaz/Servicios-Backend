<?php
 
 require __DIR__ . '/vendor/autoload.php';

$sid = "ACf8cbe95b563dd7232ccffe0744d796fd";
$token = "7b5658414ab1b1388a05e932659e3993";
$client = new Twilio\Rest\Client($sid, $token);

 
if (isset($_POST['recipientNumber'])) {
    $recipientNumber = $_POST['recipientNumber'];
    // Resto del código para procesar $recipientNumber
} else {
    // Manejo de errores en caso de que 'recipientNumber' no esté definido
    echo "El campo 'recipientNumber' no se envió en la solicitud POST.";
}


$otp = mt_rand(100000, 999999);

$message = "Código de verificación para Saint Remi es: $otp";
 

try {
    $message = $client->messages->create(
        $recipientNumber,
        [
            'from' => '+16124243981',
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

 