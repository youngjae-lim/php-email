<?php

/**
 * Start the timer
 */
$start_time = microtime(true);


/**
 * Composer autoloader
 */
require '../vendor/autoload.php';


/**
 * Connect to the queue
 */
$queue = new Queue(Config::QUEUE_HOST, Config::QUEUE_PORT, Config::QUEUE_USER, Config::QUEUE_PASSWORD, Config::QUEUE_NAME);


/**
 * Send the data to the queue
 */
$data = [
    'from' => 'sender@example.com',
    'to' => 'recipient@example.com',
    'subject' => 'An email sent from PHP',
    'body' => 'Hello! The time is ' . date('H:i:s')
];

$queue->publish($data);


/**
 * Close the connection to the RabbitMQ server
 */
$queue->disconnect();


/**
 * Calculate the time taken to execute the script
 */
$end_time = microtime(true);
$time = number_format($end_time - $start_time, 5);


/**
 * Return to index.php
 */
header("Location: index.php?time=$time");
exit();
