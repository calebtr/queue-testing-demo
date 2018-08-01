<?php

namespace Phpdx;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use Dotenv;

class RadikoRabbitMQ {

    /**
     * @return \PhpAmqpLib\Connection\AMQPStreamConnection
     */
    public static function getConnection() {

        $dotenv = new Dotenv(__DIR__ . '/../../');
        $dotenv->load();

        $host = getenv('RABBITMQ_HOST');
        $port = getenv('RABBITMQ_PORT');
        $user = getenv('RABBITMQ_USERNAME');
        $pass = getenv('RABBITMQ_PASSWORD');

        return new AMQPStreamConnection( $host, $port, $user, $pass );
    }

}