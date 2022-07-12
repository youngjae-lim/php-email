<?php

/**
 * Queue class
 *
 * PHP version 7.0
 */

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use MessagePack\Packer;

class Queue
{

    /**
     * RabbitMQ connection
     *
     * @var AMQPStreamConnection
     */
    protected $connection;

    /**
     * RabbitMQ connection channel
     *
     * @var AMQPChannel
     */
    protected $channel;

    /**
     * Queue name
     *
     * @var string
     */
    protected $name;

    /**
     * Class constructor
     *
     * @param string $host     RabbitMQ server host
     * @param int    $port     RabbitMQ server port
     * @param string $username RabbitMQ server username
     * @param string $password RabbitMQ server password
     * @param string $name     Queue name
     *
     * @return void
     */
    public function __construct($host, $port, $username, $password, $name)
    {
        $this->connection = new AMQPStreamConnection($host, $port, $username, $password);
        $this->channel = $this->connection->channel();

        $this->channel->queue_declare($name, false, false, false, false);
        $this->name = $name;
    }

    /**
     * Send an item to the queue, packing it into Message Pack format first
     *
     * @param mixed $data The data to be sent
     *
     * @return void
     */
    public function publish($data)
    {
        $packer = new Packer();
        $packed = $packer->pack($data);

        $message = new AMQPMessage($packed);
        $this->channel->basic_publish($message, '', $this->name);
    }

    /**
     * Close the connection and disconnect from the RabbitMQ server
     *
     * @return void
     */
    public function disconnect()
    {
        $this->channel->close();
        $this->connection->close();
    }

    /**
     * Process the items in the queue
     *
     * @param callable $callback The data to be sent
     *
     * @return void
     */
    public function process($callback)
    {
        $this->channel->basic_consume($this->name, '', false, true, false, false, $callback);

        while(count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }
}
