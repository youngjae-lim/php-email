<?php

/**
 * Composer autoloader
 */
require '../vendor/autoload.php';


/**
 * Import classes
 */
use MessagePack\Unpacker;


/**
 * Connect to the queue
 */
$queue = new Queue(Config::QUEUE_HOST, Config::QUEUE_PORT, Config::QUEUE_USER, Config::QUEUE_PASSWORD, Config::QUEUE_NAME);


/**
 * Process the messages
 */
echo "Waiting for messages. Press CTRL+C to exit\n";

$queue->process(function($message) {

    echo 'Processing message... ';

    /**
     * Get the data from the message
     */
    $data = (new Unpacker())->unpack($message->body);


    /**
     * Send the email
     */
    $mail = new PHPMailer();

    $mail->isSMTP();
    $mail->Host = Config::SMTP_HOST;
    $mail->Port = Config::SMTP_PORT;
    $mail->SMTPAuth = true;
    $mail->Username = Config::SMTP_USER;
    $mail->Password = Config::SMTP_PASSWORD;
    $mail->SMTPSecure = 'tls';
    $mail->CharSet = 'UTF-8';

    $mail->setFrom($data['from']);
    $mail->addAddress($data['to']);

    $mail->Subject = $data['subject'];
    $mail->Body = $data['body'];

    if ( ! $mail->send()) {
        echo 'send error: ' . $mail->ErrorInfo . "\n";
    } else {
        echo "email sent.\n";
    }
});
