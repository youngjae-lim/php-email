<?php

/**
 * Configuration settings
 *
 * PHP version 7.0
 */
class Config
{

    /**
     * SMTP host
     *
     * @var string
     */
    const SMTP_HOST = 'mail.example.com';

    /**
     * SMTP port
     *
     * @var int
     */
    const SMTP_PORT = 587;

    /**
     * SMTP user
     *
     * @var string
     */
    const SMTP_USER = 'sender@example.com';

    /**
     * SMTP password
     *
     * @var string
     */
    const SMTP_PASSWORD = 'secret';

    /**
     * Queue host
     *
     * @var string
     */
    const QUEUE_HOST = 'localhost';

    /**
     * Queue port
     *
     * @var int
     */
    const QUEUE_PORT = 5672;

    /**
     * Queue user
     *
     * @var string
     */
    const QUEUE_USER = 'guest';

    /**
     * Queue password
     *
     * @var string
     */
    const QUEUE_PASSWORD = 'guest';

    /**
     * Queue name
     *
     * @var string
     */
    const QUEUE_NAME = 'emails';
}
