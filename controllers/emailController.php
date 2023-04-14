<?php

require_once 'vendor/autoload.php';
require_once 'config/constants.php';
// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
  ->setUsername(EMAIL)
  ->setPassword(PASSWORD);

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);


function sendVerificationEmail($userEmail, $token)
{

    global $mailer;
    $body = '<!DOCTYPE html>
    <html lang = "en" dir= "ltr">
        <head>
            <meta charset = "utf-8">
            <title>Verify Email</title>
        </head>
        <body>
        <div class = "wrapper">
                <p>You have beeen registered to the portal of Arielle for Africa.
                    Click the link below to verify your account </p>
    
                    <a href= "http://localhost/ARFAEL/ARFAEL/index/confirm.php?token=' .$token.'">
                    Verify your account
                </a>
    
            </div>
        </body>
    </html>';
 // Create a message
$message = (new Swift_Message('Verify your email address'))
->setFrom(EMAIL)
->setTo($userEmail)
->setBody($body, 'text/html');

// Send the message
$result = $mailer->send($message);

}

function sendPasswordResetLink($userEmail, $token){

    global $mailer;
    $body = '<!DOCTYPE html>
    <html lang = "en" dir= "ltr">
        <head>
            <meta charset = "utf-8">
            <title>Verify Email</title>
        </head>
        <body>
        <div class = "wrapper">
                <p>
                Hello there,

                Please click the link below to reset your password.
                </p>
    
                    <a href= "http://localhost/ARFAEL/PHP/index/confirm.php?password-token=' .$token.'">
                   Reset your password
                </a>
    
            </div>
        </body>
    </html>';
 // Create a message
$message = (new Swift_Message('Reset your password'))
->setFrom(EMAIL)
->setTo($userEmail)
->setBody($body, 'text/html');

// Send the message
$result = $mailer->send($message);


}



?> 