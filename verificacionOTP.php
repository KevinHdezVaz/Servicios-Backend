<?php
require 'vendor/autoload.php';

use Twilio\Rest\Client;

$sid = getenv("ACf8cbe95b563dd7232ccffe0744d796fd");
$token = getenv("7b5658414ab1b1388a05e932659e3993");
$twilio = new Client($sid, $token);

$verification = $twilio->verify->v2->services("VAXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")
                                   ->verifications
                                   ->create("+7811031182", "sms");

print($verification->status);
?>
